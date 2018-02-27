<?php
declare(strict_types=1);

namespace Roulette;

abstract class Player
{

    /**
    * Player available stake
    *
    * @var int
    */
    protected $stake;

    /**
    * The number of rounds left to play.
    *
    * @var int
    */
    protected $roundsToGo;

    /**
    * Table used to place Bets
    *
    * @var Table
    */
    protected $table;

    /**
    * Updates the Table with the various bets.
    */
    abstract public function placeBets();

    /**
    * Construct Player class
    *
    * @param Table
    */
    public function __construct(Table $table)
    {     
        $binBuilder = new BinBuilder();
    
        $this->stake = 500;
        $this->table = $table;    
        $this->wheel = $binBuilder->buildBins($wheel);
        $this->black = $this->wheel->getOutcome("Black");
    }

    /**
    * Notification from the Game that the Bet was a winner
    *
    * @param Bet
    */
    public function win(Bet $bet)
    {
        $this->stake = $this->stake + $bet->winAmount();
    }

    /**
    * Notification from the Game that the Bet lost
    *
    * @param Bet
    */
    public function lose(Bet $bet)
    {
        $this->stake = $this->stake + $bet->winAmount();
    }

    /**
     * Returns true while the player is still active.
     * 
     * @return bool
     */
    public function isPlaying()
    {
        return true;
    }

}
