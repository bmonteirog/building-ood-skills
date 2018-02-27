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
        $this->table = $table;
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
        $this->stake = $this->stake - $bet->loseAmount();
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

    /**
     * Player amount setter
     *
     * @param int
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Player stake setter
     *
     * @param int
     */
    public function setStake(int $stake)
    {
        $this->stake = $stake;
    }

    /**
     * Player stake getter
     *
     * @return int
     */
    public function getStake()
    {
        return $this->stake;
    }
}
