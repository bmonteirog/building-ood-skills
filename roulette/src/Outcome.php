<?php 
declare(strict_types=1);

namespace Roulette;

/**
 * Encapsulates a given possible outcome and its odds.
 */
class Outcome
{
  
  /**
   * @var string
   */
  protected $name;
  
  /**
   * @var int
   */
  protected $odds;
  
  /**
   * Constructor
   *
   * @param string $name
   * @param int $odds
   */
  public function __construct(string $name, int $odds)
  {
    $this->name = $name;
    $this->odds = $odds;
  }
  
  /**
   * Multiply the odds by a given amount. Returns the product.
   *
   * @param float $amount
   *
   * @return float 
   */
  public function winAmount($amount)
  {
    return $this->odds * $amount;
  }
  
  /**
   * Easy-to-read representation of the Outcome
   *
   * @return string
   */
  public function __toString()
  {
    return "{$this->name} ({$this->odds}:1)";
  }
  
  /**
   * Compares other instance of Outcome to check if both are the same.
   *
   * @return bool
   */
  public function equals(Outcome $otherOutcome)
  {
    return $this->getName() === $otherOutcome->getName();
  }
  
  /**
   * Hashed Name getter
   *
   * @return string
   */
  public function getHash()
  {
    return hash('ripemd160', $this->name);
  }
  
  /**
   * Name Getter
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
}