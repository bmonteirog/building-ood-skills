<?php
declare(strict_types=1);

namespace Roulette;

/**
 * This player waits until the wheel has spun red 
 * seven times in a row before betting black.
 */
class SevenRedsPlayer extends MartingalePlayer
{

    /**
     * The number of reds yet to go. This starts at 7, 
     * is reset to 7 on each non-red outcome, and 
     * decrements by 1 on each red outcome.
     */
    protected $redCounts = 7;

    /**
     * If redCount is zero, this places a bet on 
     * black, using the bet multiplier.
     */
    public function placeBets()
    {
        if ($this->redCounts == 0) {
            parent::placeBets();            
        }
    }

    /**
     * This is notification from the Game of all the 
     * winning outcomes. If this vector includes red, 
     * redCount is decremented. Otherwise, redCount is
     * reset to 7.
     * 
     * @param Bin
     */
    public function winners(Bin $winningBin)
    {
        $redOutcome = new Outcome("Red", 1);

        if ($winningBin->hasOutcome($redOutcome)) {
            $this->redCounts--;
        } else {
            $this->redCounts = 7;
        }

        $this->roundsPlayed = $this->roundsPlayed + 1;
    }
}