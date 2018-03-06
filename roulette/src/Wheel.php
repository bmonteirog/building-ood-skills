<?php 
declare(strict_types=1);

namespace Roulette;

use Exception;
use Roulette\BinBuilder;
use Clickalicious\Rng\Generator;

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
   * @var Bin[]
   */
  public $rng;
  
  /**
   * @var Outcome[]
   */
  protected $allOutcomes;
  
  /**
   * Using 'map_' prefix since an array using a valid integer as key will
   * cast the index to integer instead of using it as a string, making
   * the key search fail.
   *
   * @var string
   */
  protected $mappingPrefix = 'map_';  
  
  /**
   * Wheel Constructor
   */
  public function __construct()
  {
    for ($i=0; $i < 38; $i++) {       
      $this->bins[$i] = new Bin();
    }

    $binBuilder = new BinBuilder();
    $binBuilder->buildBins($this);

    $this->rng = new Generator(Generator::MODE_PHP_MERSENNE_TWISTER);
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
      $this->allOutcomes[$this->mappingPrefix . $outcome->getName()] = $outcome;      
      return true;
    } catch (Exception $e) {
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
   * Returns an outcome by its name
   *
   * @return mixed
   */
  public function getOutcome(string $name)
  {
      foreach ($this->allOutcomes as $outcomeName => $outcome) {
        if ($outcomeName == $this->mappingPrefix . $name) {
          return $outcome;
        }
      }
      
      return null;
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
    return $this->rng->generate(0, 37);
  }
}