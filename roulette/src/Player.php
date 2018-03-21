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
     * Amount to bet
     *
     * @var int
     */
    protected $amount;

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
     * Stores the total of rounds played
     *
     * @var int
     */
    protected $roundsPlayed = 0;

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
     * Updates the Table with the various bets.
     */
    abstract public function placeBets();

    /**
     * Restart player's vars
     */
    abstract public function restartPlayer();

    /**
     * The game will notify a player of each spin using this method.
     * 
     * @param Bin $winningBin
     */
    public function winners(Bin $winningBin){}

    /**
     * Notification from the Game that the Bet was a winner
     *
     * @param Bet
     */
    public function win(Bet $bet)
    {
        $this->stake = $this->stake + $bet->winAmount();
        $this->roundsPlayed = $this->roundsPlayed + 1;
    }

    /**
     * Notification from the Game that the Bet lost
     *
     * @param Bet
     */
    public function lose(Bet $bet)
    {
        $this->stake = $this->stake - $bet->loseAmount();
        $this->roundsPlayed = $this->roundsPlayed + 1;
    }

    /**
     * Returns true while the player is still active.
     * 
     * @return bool
     */
    public function isPlaying()
    {
        $notPlayedEnough = $this->roundsPlayed < $this->roundsToGo;
        $hasEnoughStake = $this->stake > 0;
        return $notPlayedEnough && $hasEnoughStake;
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
     * Player amount getter
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Player Rounds to Go setter
     *
     * @param int
     */
    public function setRoundsToGo(int $roundsToGo)
    {
        $this->roundsToGo = $roundsToGo;
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

    /**
     * Player rounds played setter
     *
     * @return int
     */
    public function setRoundsPlayed(int $roundsPlayed)
    {
        return $this->roundsPlayed = $roundsPlayed;
    }

}
