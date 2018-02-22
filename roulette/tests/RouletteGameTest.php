<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Roulette\Game;
use Roulette\Table;
use Roulette\Wheel;
use Roulette\Passenger57;

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
     $wheel = new Wheel();
     $table = new Table();
     
     $player = new Passenger57($table, $wheel);
     $game = new Game($wheel, $table);
     
     // Will output the sequence 18, 32, 22, 8, 0, 19, 37
     srand(7);
     
     $game->cycle($player); // Red    (lose 15)     money: 485
     $game->cycle($player); // Red    (lose 15)     money: 470
     $game->cycle($player); // Black  (win 15 + 15) money: 500
     $game->cycle($player); // Black  (win 15 + 15) money: 530
     $game->cycle($player); // 0      (lose 15)     money: 515
     
     $this->assertTrue($player->getMoney() == 515);
   }
   
 }