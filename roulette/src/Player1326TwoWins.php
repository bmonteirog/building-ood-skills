<?php
declare(strict_types=1);

namespace Roulette;

class Player1326TwoWins extends Player1326State
{

    /**
     * Player State constructor
     */
    public function __construct(Player1326 $player)
    {
        parent::__construct($player);
        $this->multiplier = 2;
        $this->nextStateWin = 'Roulette\Player1326ThreeWins';
    }

}