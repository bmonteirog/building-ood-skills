<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Uses the Fibonacci betting system. This player allocates their 
 * available budget into a sequence of bets that have an accelerating 
 * potential gain.
 */
class FibonacciPlayer extends Player
{

    /**
     * This is the most recent bet amount.
     * 
     * @var int
     */
    protected $recent;

    /**
     * This is the bet amount previous to the most recent bet amount.
     * 
     * @var int
     */
    protected $previous;

    /**
     * Fibonacci Player constructor
     */
    public function __construct(Table $table)
    {
        parent::__construct($table);
        $this->restartCounters();
    }

    /**
     * Set internal counters to it's initial values
     */
    private function restartCounters()
    {
        $this->recent = 1;
        $this->previous = 0;
    }

    /**
     * Updates internal counters to go forward in the sequence
     */
    private function increaseCounters()
    {
        $next = $this->recent + $this->previous;
        $this->previous = $this->recent;
        $this->recent = $next;
    }

    /**
     * Updates the Table with the various bets.
     */    
    public function placeBets()
    {
        $outcome = new Outcome("Black", 1);
        $bet = new Bet($this->recent, $outcome);
        $this->table->placeBet($bet);
    }

    /**
     * Notification from the Game that the Bet was a winner
     *
     * @param Bet
     */
    public function win(Bet $bet)
    {
        parent::win($bet);
        $this->restartCounters();
    }

    /**
     * Notification from the Game that the Bet lost
     *
     * @param Bet
     */
    public function lose(Bet $bet)
    {
        parent::lose($bet);
        $this->increaseCounters();
    }

    /**
     * Restart player's vars
     */
    public function restartPlayer()
    {
        $this->restartCounters();
        $this->setRoundsPlayed(0);
    }    
}