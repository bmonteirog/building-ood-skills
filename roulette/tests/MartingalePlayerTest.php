<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Outcome,
  Bet,
  MartingalePlayer,
  Wheel,
  Table,
  BinBuilder,
  Game
};

/**
 * This test should synthesize a fixed list of Outcome s, Bin s, and calls a Martingale
 * instance with various sequences of reds and blacks to assure that the bet doubles 
 * appropriately on each loss, and is reset on each win.
 */
final class MartingalePlayerTest extends TestCase
{

  protected $outcomes;

  protected $player;

  protected $table;

  public function setUp()
  {
    $this->outcomes['black'] = new Outcome('Black', 1);
    $this->outcomes['red'] = new Outcome('Red', 1);

    $binBuilder = new BinBuilder();    
    $this->table = new Table($binBuilder->buildBins(new Wheel()));
    $this->player = new MartingalePlayer($this->table);
    $this->player->setStake(500);
    $this->player->setAmount(15);
    $this->player->setRoundsToGo(50);
  }
  
  public function testCanDoubleBets()
  {
    $this->player->outcome = $this->outcomes['black'];

    $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
    $rngStub->method('generate')->will($this->onConsecutiveCalls(19, 21, 36));
    $this->table->wheel->rng = $rngStub;

    $game = new Game($this->table->wheel, $this->table);

    $game->cycle($this->player); // Red    (lose 15)     money: 485
    $game->cycle($this->player); // Red    (lose 45)     money: 455
    $game->cycle($this->player); // Red    (lose 60)     money: 395
    
    $this->assertTrue($this->player->getStake() == 395);
  }

  public function testIsResetOnWin()
  {
    $this->player->outcome = $this->outcomes['black'];

    $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
    $rngStub->method('generate')->will($this->onConsecutiveCalls(19, 21, 24, 36));
    $this->table->wheel->rng = $rngStub;

    $game = new Game($this->table->wheel, $this->table);

    $game->cycle($this->player); // Red    (lose 15)     money: 485
    $game->cycle($this->player); // Red    (lose 30)     money: 455    
    $game->cycle($this->player); // Black  (win 120)     money: 575 Reset Counters
    $game->cycle($this->player); // Red    (lose 15)     money: 560    
    
    $this->assertTrue($this->player->getStake() == 560);
  }

}