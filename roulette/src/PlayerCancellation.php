<?php
declare(strict_types=1);

namespace Roulette;

/**
 * PlayerCancellation uses the cancellation betting system. This player allocates their 
 * available budget into a sequence of bets that have an accelerating potential gain as 
 * well as recouping any losses
 */
class PlayerCancellation extends Player
{

    /**
     * This array keeps the bet amounts; wins are removed from this list 
     * and losses are appended to this list. The current bet is the first 
     * value plus the last value
     * 
     * @var int[]
     */
    protected $sequence;

    /**
     * This is the player’s preferred Outcome.
     * 
     * @var Outcome
     */
    protected $outcome;

    /**
     * Player Cancellation constructor
     */
    public function __construct(Table $table)
    {
        parent::__construct($table);
        $this->outcome = $table->wheel->getOutcome("Black");
        $this->resetSequence();
    }

    /**
     * Returns true while the player is still active.
     * 
     * @return bool
     */
    public function isPlaying()
    {
        $notPlayedEnough = $this->roundsPlayed < $this->roundsToGo;
        $sequenceNotEmpty = count($this->sequence) > 1;
        $hasEnoughStake = $this->stake > 0;
        return $notPlayedEnough && $sequenceNotEmpty && $hasEnoughStake;
    }

    /**
     * Puts the initial sequence of six Integer instances 
     * into the sequence variable.
     */
    private function resetSequence()
    {
        $this->sequence = range(1, 6);
    }

    /**
     * Restart player's vars
     */
    public function restartPlayer()
    {
        $this->resetSequence();
        $this->setRoundsPlayed(0);
    }

    /**
     * Creates a bet from the sum of the first and last 
     * values of sequence and the preferred outcome.
     */    
    public function placeBets()
    {
        $firstValue = reset($this->sequence);
        $lastValue = end($this->sequence);
        if (($firstValue + $lastValue) > 1000) {
            $break = 'point';
        }
        if (($firstValue + $lastValue) > 5000) {
            $break = 'point';
        }
        $bet = new Bet($firstValue + $lastValue, $this->outcome);
        $this->table->placeBet($bet);
    }

    /**
     * Uses the superclass method to update the stake with an amount won.
     * It then removes the fist and last element from sequence.
     * 
     * @param Bet $bet
     */
    public function win(Bet $bet)
    {
        parent::win($bet);
        array_shift($this->sequence);
        array_pop($this->sequence);
    }

    /**
     * Uses the superclass method to update the stake with an amount lost. 
     * It then appends the sum of the first and list elements of sequence 
     * to the end of sequence as a new Integer value.
     * 
     * @param Bet $bet
     */
    public function lose(Bet $bet)
    {
        parent::lose($bet);
        $first = reset($this->sequence);
        $last = end($this->sequence);
        array_push($this->sequence, $first + $last);
    }    
}