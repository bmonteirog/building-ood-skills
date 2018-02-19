<?php 
declare(strict_types=1);

namespace Roulette;

use Roulette\Outcome;
use Roulette\Bin;

/**
 * Container for the Bins and picks one Bin at random
 */
class Wheel
{

  /**
   * @var Bin[]
   */
  protected $bins;
  
  /**
   * Wheel Constructor
   */
  public function __construct()
  {
    for ($i=0; $i < 38; $i++) {       
      $this->bins[$i] = new Bin();
    }
  }

  /**
   * Adds a given Outcome to the designated Bin
   *
   * @return bool
   */
  public function addOutcome(int $number, Outcome $outcome)
  {
    try {
      $this->bins[$number] = $this->bins[$number]->withValue($outcome);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
  
  /**
   * Generates a random number between 0 and 37 and return the correct Bin
   *
   * @return Bin
   */
  public function next()
  {
    return $this->get($this->generateRandomNumber());
  }
  
  /**
   * Returns the given Bin from the internal Collection
   *
   * @return Bin
   */
  private function get(int $bin)
  {
    return $this->bins[$bin];
  }
  
  /**
   * Generates a random number between 0 and 37 and return the correct Bin
   *
   * @return int
   */
  private function generateRandomNumber()
  {
    return rand(0, 37);
  }
}