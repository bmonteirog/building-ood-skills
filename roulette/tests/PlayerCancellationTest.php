<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
    PlayerCancellation,
    Wheel,
    Table,
    Game
};

/**
 * A unit test of the PlayerCancellation class. 
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
final class PlayerCancellationTest extends TestCase
{

    protected $player;

    protected $table;

    public function setUp()
    {
        $this->table = new Table(new Wheel());
        $this->player = new PlayerCancellation($this->table);
        $this->player->setStake(500);
        $this->player->setRoundsToGo(50);
    }

    public function testCanCreatePlayer()
    {
        $this->assertInstanceOf('\Roulette\PlayerCancellation', $this->player);
    }

    public function testPlayerFlowWWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Win 7
        $this->assertEquals($this->player->getStake(), 514);

        $game->cycle($this->player); // Bet 3 + 4 Win 7
        $this->assertEquals($this->player->getStake(), 521);

        $game->cycle($this->player); // No bet
        $this->assertEquals($this->player->getStake(), 521);
    }

    public function testPlayerFlowWLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 2 + 7 Win 9
        $this->assertEquals($this->player->getStake(), 509);

        $game->cycle($this->player); // Bet 3 + 5 Win 8
        $this->assertEquals($this->player->getStake(), 517);
    }

    public function testPlayerFlowWWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Win 7
        $this->assertEquals($this->player->getStake(), 514);

        $game->cycle($this->player); // Bet 3 + 4 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 3 + 7 Win 10
        $this->assertEquals($this->player->getStake(), 517);
    }

    public function testPlayerFlowWWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Win 7
        $this->assertEquals($this->player->getStake(), 514);

        $game->cycle($this->player); // Bet 3 + 4 Win 7
        $this->assertEquals($this->player->getStake(), 521);

        $game->cycle($this->player); // No bet
        $this->assertEquals($this->player->getStake(), 521);
    }

    public function testPlayerFlowLWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Win 8
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 2 + 6 Win 8
        $this->assertEquals($this->player->getStake(), 509);

        $game->cycle($this->player); // Bet 3 + 5 Win 8
        $this->assertEquals($this->player->getStake(), 517);
    }

    public function testPlayerFlowWLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 2 + 7 Lose 9 -> add 9
        $this->assertEquals($this->player->getStake(), 491);

        $game->cycle($this->player); // Bet 2 + 9 Win 11
        $this->assertEquals($this->player->getStake(), 502);
    }

    public function testPlayerFlowWWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Win 7
        $this->assertEquals($this->player->getStake(), 514);

        $game->cycle($this->player); // Bet 3 + 4 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 3 + 7 Lose 10 -> add 10
        $this->assertEquals($this->player->getStake(), 497);
    }

    public function testPlayerFlowLLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Bet 1 + 8 Win 9
        $this->assertEquals($this->player->getStake(), 494);

        $game->cycle($this->player); // Bet 2 + 7 Win 9
        $this->assertEquals($this->player->getStake(), 503);
    }

    public function testPlayerFlowLWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Win 8
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 2 + 6 Win 8
        $this->assertEquals($this->player->getStake(), 509);

        $game->cycle($this->player); // Bet 3 + 5 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 501);
    }

    public function testPlayerFlowWLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 2 + 7 Lose 9 -> add 9
        $this->assertEquals($this->player->getStake(), 491);

        $game->cycle($this->player); // Bet 2 + 9 Lose 11 -> add 11
        $this->assertEquals($this->player->getStake(), 480);
    }

    public function testPlayerFlowLLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Bet 1 + 8 Lose 9 -> add 9
        $this->assertEquals($this->player->getStake(), 476);

        $game->cycle($this->player); // Bet 1 + 9 Win 10
        $this->assertEquals($this->player->getStake(), 486);
    }

    public function testPlayerFlowLWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Win 8
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 2 + 6 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 2 + 8 Lose 10 -> add 10
        $this->assertEquals($this->player->getStake(), 483);
    }

    public function testPlayerFlowLLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Bet 1 + 8 Win 9
        $this->assertEquals($this->player->getStake(), 494);

        $game->cycle($this->player); // Bet 2 + 7 Lose 9 -> add 9
        $this->assertEquals($this->player->getStake(), 485);
    }

    public function testPlayerFlowWLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Win 7
        $this->assertEquals($this->player->getStake(), 507);

        $game->cycle($this->player); // Bet 2 + 5 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Bet 2 + 7 Win 9
        $this->assertEquals($this->player->getStake(), 509);

        $game->cycle($this->player); // Bet 3 + 5 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 501);
    }

    public function testPlayerFlowLWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Win 8
        $this->assertEquals($this->player->getStake(), 501);

        $game->cycle($this->player); // Bet 2 + 6 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 2 + 8 Win 10
        $this->assertEquals($this->player->getStake(), 503);
    }

    public function testPlayerFlowLLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Bet 1 + 6 Lose 7 -> add 7
        $this->assertEquals($this->player->getStake(), 493);

        $game->cycle($this->player); // Bet 1 + 7 Lose 8 -> add 8
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Bet 1 + 8 Lose 9 -> add 9
        $this->assertEquals($this->player->getStake(), 476);

        $game->cycle($this->player); // Bet 1 + 9 Lose 10 -> add 10
        $this->assertEquals($this->player->getStake(), 466);
    }
}
