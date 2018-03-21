<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
    FibonacciPlayer,
    Wheel,
    Table,
    Game
};

/**
 * A unit test of the FibonacciPlayer class. 
 * There are 16 different sequences of four winning and losing bets. 
 * These range from four losses in a row to four wins in a row. 
 * This should be sufficient to exercise the class and see the 
 * changes in the bet amount.
 * 
 * WWWW 
 * WLWW WWLW WWWL LWWW
 * WLLW WWLL LLWW LWWL
 * WLLL LLLW LWLL LLWL
 * WLWL LWLW
 * LLLL
 */
class FibonacciPlayerTest extends TestCase
{

    protected $player;

    protected $table;

    public function setUp()
    {
        $this->table = new Table(new Wheel());
        $this->player = new FibonacciPlayer($this->table);
        $this->player->setStake(500);
        $this->player->setRoundsToGo(50);
    }

    public function testCanCreatePlayer()
    {
        $this->assertInstanceOf('\Roulette\FibonacciPlayer', $this->player);
    }

    public function testPlayerFlowWWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 503);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 504);
    }

    public function testPlayerFlowWLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);
    }

    public function testPlayerFlowWWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);
    }

    public function testPlayerFlowWWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 503);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 502);
    }

    public function testPlayerFlowLWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);
    }

    public function testPlayerFlowWLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 2 Win 2
        $this->assertEquals($this->player->getStake(), 501);
    }

    public function testPlayerFlowWWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 502);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);
    }

    public function testPlayerFlowLLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 498);

        $game->cycle($this->player); // Bet 2 Win 2
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);
    }

    public function testPlayerFlowLWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);
    }

    public function testPlayerFlowWLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 2 Lose 2
        $this->assertEquals($this->player->getStake(), 497);
    }

    public function testPlayerFlowLLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 498);
 
        $game->cycle($this->player); // Bet 2 Lose 2
        $this->assertEquals($this->player->getStake(), 496);

        $game->cycle($this->player); // Bet 3 Win 3
        $this->assertEquals($this->player->getStake(), 499);
    }

    public function testPlayerFlowLWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 498);
    }

    public function testPlayerFlowLLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 498);

        $game->cycle($this->player); // Bet 2 Win 2
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);
    }

    public function testPlayerFlowWLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 500);
    }

    public function testPlayerFlowLWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Win 1
        $this->assertEquals($this->player->getStake(), 500);
    }

    public function testPlayerFlowLLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 499);

        $game->cycle($this->player); // Bet 1 Lose 1
        $this->assertEquals($this->player->getStake(), 498);

        $game->cycle($this->player); // Bet 2 Lose 2
        $this->assertEquals($this->player->getStake(), 496);

        $game->cycle($this->player); // Bet 3 Lose 3
        $this->assertEquals($this->player->getStake(), 493);
    }

}