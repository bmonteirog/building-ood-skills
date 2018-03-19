<?php
declare(strict_types=1);

namespace Roulette;

class Player1326NoWins extends Player1326State
{

    /**
     * Player State constructor
     */
    public function __construct(Player1326 $player)
    {
        parent::__construct($player);
        $this->multiplier = 1;
        $this->nextStateWin = 'Roulette\Player1326OneWin';
    }

}