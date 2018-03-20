<?php
declare(strict_types=1);

namespace Roulette;

/**
 * This player doubles their bet on every loss and resets their
 * bet to a base amount on each win.
 */
class MartingalePlayer extends Player
{

    /**
     * The number of losses. This is the number of times to double the bet.
     * 
     * @var int
     */
    protected $lossCount = 0;

    /**
     * The the bet multiplier, based on the number of losses. 
     * This starts at 1, and is reset to 1 on each win. It is doubled in each loss. 
     * This is always equal to 2 ^ lossCount.
     */
    protected $betMultiple = 1;

    /**
    * Notification from the Game that the Bet was a winner
    *
    * @param Bet
    */
    public function win(Bet $bet)
    {
        parent::win($bet);

        $this->lossCount = 0;
        $this->betMultiple = 1;
    }

    /**
    * Notification from the Game that the Bet lost
    *
    * @param Bet
    */
    public function lose(Bet $bet)
    {
        parent::lose($bet);
        
        $this->lossCount = $this->lossCount + 1;
        $this->betMultiple = $this->lossCount * 2;
    }

    /**
     * Updates the Table with the various bets.
     */
    public function placeBets()
    {
        $outcome = new Outcome("Black", 1);
        $amount = $this->betMultiple * $this->amount;
        
        $bet = new Bet($amount, $outcome);
        $this->table->placeBet($bet);
    }

    /**
     * Restart player's vars
     */
    public function restartPlayer()
    {
        $this->lossCount = 0;
        $this->betMultiple = 1;
        $this->setRoundsPlayed(0);
    }

}