<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
    Player1326,
    Wheel,
    Table,
    Game
};

/**
 * A unit test of the Player1326 class. This test should synthesize a 
 * fixed list of Outcomes, Bins, and calls a Player1326 instance with 
 * various sequences of reds and blacks. There are 16 different sequences 
 * of four winning and losing bets. These range from four losses in a row to four wins in a row.
 * 
 * WWWW 
 * WLWW WWLW WWWL LWWW
 * WLLW WWLL LLWW LWWL
 * WLLL LLLW LWLL LLWL
 * WLWL LWLW
 * LLLL
 */
final class Player1326Test extends TestCase
{

    protected $player;

    protected $table;

    public function setUp()
    {
        $this->table = new Table(new Wheel());
        $this->player = new Player1326($this->table);
        $this->player->setStake(500);
        $this->player->setAmount(15);
        $this->player->setRoundsToGo(50);
    }

    public function testCanCreatePlayer()
    {
        $this->assertInstanceOf('\Roulette\Player1326', $this->player);
    }

    public function testPlayerFlowWWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 wins 45
        $this->assertEquals($this->player->getStake(), 560);

        $game->cycle($this->player); // Multiplier 2 wins 30
        $this->assertEquals($this->player->getStake(), 590);

        $game->cycle($this->player); // Multiplier 6 wins 90
        $this->assertEquals($this->player->getStake(), 680);
    }

    public function testPlayerFlowWLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 3 wins 45
        $this->assertEquals($this->player->getStake(), 530);
    }

    public function testPlayerFlowWWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 wins 45
        $this->assertEquals($this->player->getStake(), 560);

        $game->cycle($this->player); // Multiplier 2 lose 30
        $this->assertEquals($this->player->getStake(), 530);

        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 545);
    }

    public function testPlayerFlowWWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 wins 45
        $this->assertEquals($this->player->getStake(), 560);

        $game->cycle($this->player); // Multiplier 2 wins 30
        $this->assertEquals($this->player->getStake(), 590);

        $game->cycle($this->player); // Multiplier 6 lose 90
        $this->assertEquals($this->player->getStake(), 500);
    }

    public function testPlayerFlowLWWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Multiplier 3 wins 45
        $this->assertEquals($this->player->getStake(), 545);

        $game->cycle($this->player); // Multiplier 2 wins 30
        $this->assertEquals($this->player->getStake(), 575);
    }

    public function testPlayerFlowWLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 wins 15
        $this->assertEquals($this->player->getStake(), 470);
    }

    public function testPlayerFlowWWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 win 45
        $this->assertEquals($this->player->getStake(), 560);

        $game->cycle($this->player); // Multiplier 2 lose 30
        $this->assertEquals($this->player->getStake(), 530);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 515);
    }

    public function testPlayerFlowLLWW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 3 win 45
        $this->assertEquals($this->player->getStake(), 530);
    }

    public function testPlayerFlowLWWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Multiplier 3 win 45
        $this->assertEquals($this->player->getStake(), 545);

        $game->cycle($this->player); // Multiplier 2 lose 30
        $this->assertEquals($this->player->getStake(), 515);
    }

    public function testPlayerFlowWLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 440);
    }

    public function testPlayerFlowLLLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 470);
    }

    public function testPlayerFlowLWLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 440);
    }

    public function testPlayerFlowLLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 440);
    }

    public function testPlayerFlowWLWL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(2, 1, 2, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 515);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 440);
    }

    public function testPlayerFlowLWLW()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 2, 1, 2));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 500);

        $game->cycle($this->player); // Multiplier 3 lose 45
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 win 15
        $this->assertEquals($this->player->getStake(), 470);
    }

    public function testPlayerFlowLLLL()
    {
        $wheelRngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
        $wheelRngStub->method('generate')->will($this->onConsecutiveCalls(1, 1, 1, 1));
        $this->table->wheel->rng = $wheelRngStub;

        $game = new Game($this->table->wheel, $this->table);
    
        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 485);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 470);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 455);

        $game->cycle($this->player); // Multiplier 1 lose 15
        $this->assertEquals($this->player->getStake(), 440);
    }

} 