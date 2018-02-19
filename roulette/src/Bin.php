<?php 
declare(strict_types=1);

namespace Roulette;

use Equip\Structure\Set as ImmutableSet;

use Roulette\Outcome;

/**
 * Bin contains a collection of Outcomes which reflect the winning bets that are
 * paid for a particular bin on a Roulette wheel. In Roulette, each spin of the 
 * wheel has a number of Outcomes. Example: A spin of 1, selects the “1” bin
 * with the following winning Outcomes: “1” , “Red” , “Odd” , “Low” , 
 * “Column 1”, “Dozen 1-12” , “Split 1-2” , “Split 1-4” , “Street 1-2-3”, 
 * “Corner 1-2-4-5” , “Five Bet” , “Line 1-2-3-4-5-6” , “00-0-1-2-3” , 
 * “Dozen 1” , “Low” and “Column 1” . These are collected into a single Bin.
 */
class Bin extends ImmutableSet
{
  
  /**
   * Check if the Bin has a given outcome
   *
   * @param Outcome
   *
   * @return bool
   */
  public function hasOutcome(Outcome $otherOutcome)
  {
    foreach ($this as $key => $outcome) {
      if ($outcome->equals($otherOutcome)) {
        return true;
      }
    }
    
    return false;
  }

}