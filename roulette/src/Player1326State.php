<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Superclass for all of the states in the 1-3-2-6 betting system.
 */
class Player1326State
{

    /**
     * The Player instance who is currently in this state. 
     * 
     * @var Player1326
     */
    protected $player;

    /**
     * Player1326State constructor
     * 
     * @param Player1326 $player
     */
    public function __construct(Player1326 $player)
    {
        $this->player = $player;
    }

    /**
     * Constructs a new Bet from the player’s preferred Outcome. 
     * Each subclass has a different multiplier used when creating this Bet.
     * 
     * @return Bet
     */
    public function currentBet()
    {
        return new \Exception('NotImplemented');
    }

    /**
     * Constructs the new Player1326State instance to be used when the bet was a winner.
     * 
     * @return Player1326State
     */
    public function nextWon()
    {
        return new \Exception('NotImplemented');
    }

    /**
     * Constructs the new Player1326State instance to be used when the bet was a loser.
     * 
     * @return Player1326State
     */
    public function nextLost()
    {
        return new Player1326NoWins($this->player);
    }

}