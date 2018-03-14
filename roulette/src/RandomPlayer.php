<?php
declare(strict_types=1);

namespace Roulette;

use Clickalicious\Rng\Generator;

/**
 * RandomPlayer is a Player who places bets in Roulette.
 */
class RandomPlayer extends Player
{

    /**
     * @var Clickalicious\Rng\Generator
     */
    public $rng;

    /**
     * Random Player Constructor
     */
    public function __construct(Table $table)
    {
        parent::__construct($table);
        $this->rng = new Generator(Generator::MODE_PHP_MERSENNE_TWISTER);
    }

    /**
     * Updates the Table with a random bet.
     */
    public function placeBets()
    {
        $bet = new Bet($this->amount, $this->selectRandomOutcome());
        $this->table->placeBet($bet);
    }

    /**
     * Selects a random Outcome
     */
    private function selectRandomOutcome()
    {
        $allOutcomes = [];
        $bins = $this->table->wheel->getAllBins();
        
        foreach ($bins as $bin) {
            foreach ($bin->getAllOutcomes() as $outcome) {
                array_push($allOutcomes, $outcome);
            }
        }

        return $allOutcomes[$this->rng->generate(0, count($allOutcomes))];
    }

    /**
     * The game will notify a player of each spin using this method.
     * 
     * @param Bin $winningBin
     */
    public function winners(Bin $winningBin)
    {

    }    
}