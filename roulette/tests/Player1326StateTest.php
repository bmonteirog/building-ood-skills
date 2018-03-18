<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
    Player1326State,
    Player1326NoWins,
    Player1326OneWin,
    Player1326TwoWins,
    Player1326ThreeWins
};

/**
 * A Unit test for the entire Player1326State class hierarchy. It’s possible to 
 * unit test each state class, but they’re so simple that it’s often easier to 
 * simply test the entire hierarchy.
 */
final class Player1326StateTest extends TestCase{

    /**
     * @var Player1326
     */
    protected $player;

    public function setUp()
    {
        $this->player = $this->createMock('\Roulette\Player1326');
    }

    public function testCanCreateInitialState()
    {
        $state = new Player1326State($this->player);        
        $this->assertInstanceOf('\Roulette\Player1326State', $state);
    }

    public function testCanGetNoWinsInstanceFromNextLost()
    {
        $state = new Player1326State($this->player);
        $this->assertInstanceOf('\Roulette\Player1326NoWins', $state->nextLost());
    }

    public function testCanGetOneWinInstance()
    {
        $state = new Player1326NoWins($this->player);
        $this->assertInstanceOf('\Roulette\Player1326OneWin', $state->nextWon());
    }

    public function testCanGetTwoWinsInstance()
    {
        $state = new Player1326OneWin($this->player);
        $this->assertInstanceOf('\Roulette\Player1326TwoWins', $state->nextWon());
    }

    public function testCanGetThreeWinsInstance()
    {
        $state = new Player1326TwoWins($this->player);
        $this->assertInstanceOf('\Roulette\Player1326ThreeWins', $state->nextWon());
    }

    public function testCanResetState()
    {
        $state = new Player1326ThreeWins($this->player);
        $this->assertInstanceOf('\Roulette\Player1326NoWins', $state->nextWon());
    }
}