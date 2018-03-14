<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Bet,
  RandomPlayer,
  Wheel,
  Table,
  BinBuilder,
  Game
};

/**
 * 
 */
final class RandomPlayerTest extends TestCase
{

    protected $player;

    protected $table;
  
    public function setUp()
    {
        $this->table = new Table(new Wheel());
        $this->player = new RandomPlayer($this->table);
        $this->player->setStake(500);
        $this->player->setAmount(15);
        $this->player->setRoundsToGo(50);
    }

    public function testCanplaceRandomBet()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $playerRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $playerRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2));
        $this->player->rng = $playerRngStub;
    
        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // 1 (35*15=525)
        $this->assertEquals($this->player->getStake(), 1025);

        $game->cycle($this->player); // 1 (35*15=525)
        $this->assertEquals($this->player->getStake(), 1550);

        $game->cycle($this->player); // 1 (35*15=525)
        $this->assertEquals($this->player->getStake(), 2075);
    }
}