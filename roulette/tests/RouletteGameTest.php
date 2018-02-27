<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Game,
  Table,
  Wheel,
  Passenger57,
  BinBuilder
};


/**
 * This demo program creates the Wheel, the stub
 * Passenger57 and the Table. It creates the Game object and cycles a few times.
 * Note that the Wheel returns random results, making a formal test rather 
 * difficult. We’ll address this testability issue in the next chapter.
 */
 
 final class RouletteGameTest extends TestCase
 {
   
   public function testCanCreateGame()
   {
      $binBuilder = new BinBuilder();    
      $table = new Table($binBuilder->buildBins(new Wheel()));      
     
      $player = new Passenger57($table);
      $player->setStake(500);
      $player->setAmount(15);
     
      $game = new Game($table->wheel, $table);
     
      $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
      $rngStub->method('generate')->will($this->onConsecutiveCalls(18, 32, 22, 8, 0, 19, 37));
      $table->wheel->rng = $rngStub;
     
      $game->cycle($player); // Red    (lose 15)     money: 485
      $game->cycle($player); // Red    (lose 15)     money: 470
      $game->cycle($player); // Black  (win 15 + 15) money: 500
      $game->cycle($player); // Black  (win 15 + 15) money: 530
      $game->cycle($player); // 0      (lose 15)     money: 515
     
      $this->assertTrue($player->getStake() == 515);
   }
   
 }