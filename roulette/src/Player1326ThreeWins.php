<?php
declare(strict_types=1);

namespace Roulette;

class Player1326ThreeWins extends Player1326State
{

    /**
     * Player State constructor
     */
    public function __construct(Player1326 $player)
    {
        parent::__construct($player);
        $this->multiplier = 6;
        $this->nextStateWin = 'Roulette\Player1326NoWins';
    }

}