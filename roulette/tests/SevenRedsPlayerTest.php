<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Bet,
  SevenRedsPlayer,
  Wheel,
  Table,
  BinBuilder,
  Game
};

/**
 * This test should synthesize a fixed list of Outcomes, Bins and then call a SevenReds
 * instance with various sequences of reds and blacks. One test cases can assure 
 * that no bet is placed until 7 reds have been seen. Another test case can assure 
 * that the bets double (following the Martingale betting strategy) on each loss.
 */
final class SevenRedsPlayerTest extends TestCase
{

  protected $player;

  protected $table;

  public function setUp()
  {
    $this->table = new Table(new Wheel());
    $this->player = new SevenRedsPlayer($this->table);
    $this->player->setStake(500);
    $this->player->setAmount(15);
    $this->player->setRoundsToGo(50);
  }
  
  public function testCanWaitForSevenRedsBeforeBet()
  {
    $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
    $rngStub->method('generate')->will($this->onConsecutiveCalls(19, 21, 36, 19, 21, 36, 19, 2));
    $this->table->wheel->rng = $rngStub;

    $game = new Game($this->table->wheel, $this->table);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 21   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);
    
    $game->cycle($this->player); // Red 36   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 21   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 36   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);
    
    $game->cycle($this->player); // Black    (win 15)     money: 515
    $this->assertEquals($this->player->getStake(), 515);

  }

  public function testCanDoubleBetOnLoss()
  {
    $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
    $rngStub->method('generate')->will($this->onConsecutiveCalls(
      19, 21, 36, 19, 21, 36, 19, 21, 
      36, 19, 21, 36, 19, 21, 36
    ));
    $this->table->wheel->rng = $rngStub;

    $game = new Game($this->table->wheel, $this->table);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);
    
    $game->cycle($this->player); // Red 21   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);
    
    $game->cycle($this->player); // Red 36   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 21   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 36   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 19   (no bet)     money: 500
    $this->assertEquals($this->player->getStake(), 500);

    $game->cycle($this->player); // Red 21   (lose 15)    money: 485
    $this->assertEquals($this->player->getStake(), 485);

    $game->cycle($this->player); // Red 36   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);
    
    $game->cycle($this->player); // Red 19   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);
    
    $game->cycle($this->player); // Red 21   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);

    $game->cycle($this->player); // Red 36   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);

    $game->cycle($this->player); // Red 19   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);

    $game->cycle($this->player); // Red 21   (no bet)     money: 485
    $this->assertEquals($this->player->getStake(), 485);

    $game->cycle($this->player); // Red 36   (lose 30)     money: 455
    $this->assertEquals($this->player->getStake(), 485);
  }

}