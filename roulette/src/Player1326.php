<?php
declare(strict_types=1);

namespace Roulette;

class Player1326 extends Player
{

    /**
     * This is the player’s preferred Outcome
     * 
     * @var Outcome
     */
    public $outcome;

    /**
     * This is the current state of the 1-3-2-6 betting system. 
     * It will be an instance of a subclass of Player1326State. 
     * This will be one of the four states: No Wins, One Win, Two Wins or Three Wins.
     * 
     * @var Player1326State
     */
    protected $state;

    /**
     * Initializes the state and the outcome.
     * 
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        parent::__construct($table);

        $this->outcome = $this->table->wheel->getOutcome("Black");
        $this->state = new Player1326NoWins($this);
    }

    /**
     * Updates the Table with a bet created by the current state. This method 
     * delegates the bet creation to state object’s currentBet() method.
     */
    public function placebets()
    {
        $this->table->placeBet($this->state->currentBet());
    }

    /**
     * Restart player's vars
     */
    public function restartPlayer()
    {
        $this->setRoundsPlayed(0);
    }

    /**
     * Uses the superclass method to update the stake with an amount won.
     * 
     * @param Bet $bet
     */
    public function win(Bet $bet)
    {
        parent::win($bet);
        $this->state = $this->state->nextWon();
    }

    /**
     * Uses the current state to determine what the next state will be.
     * 
     * @param Bet $bet
     */
    public function lose(Bet $bet)
    {
        parent::lose($bet);
        $this->state = $this->state->nextLost();
    }
}