<?php
declare(strict_types=1);

namespace Roulette;

class Player1326NoWins extends Player1326State
{

    /**
     * Constructs a new Bet from the player’s preferred Outcome. 
     * Each subclass has a different multiplier used when creating this Bet.
     * 
     * @return Bet
     */
    public function currentBet()
    {
        $multiplier = 1;
        return new Bet($this->player->getAmount() * $multiplier, $this->player->outcome);
    }

    /**
     * Constructs the new Player1326State instance to be used when the bet was a winner.
     * 
     * @return Player1326State
     */
    public function nextWon()
    {
        return new Player1326OneWin($this->player);
    }

}