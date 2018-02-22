<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Associates an amount, an Outcome and a Player
 */
class Bet
{
  
  /**
   * @var int
   */
   protected $amountBet;
   
   /**
    * @var Outcome
    */
   protected $outcome;
   
   /**
    * Create a new Bet of a specific amount on a specific outcome.
    *
    * @param int
    * @param Outcome
    */
   public function __construct(int $amount, Outcome $outcome)
   {
     $this->amountBet = $amount;
     $this->outcome = $outcome;
   }
  
   /**
    * Compute the amount won given the amount betted
    *
    * @return int
    */
   public function winAmount()
   {
     return $this->amountBet + $this->outcome->winAmount($this->amountBet);
   }
   
   /**
    * Compute the amount lost, e.g. the cost of placing the bet
    *
    * @return int
    */
   public function loseAmount()
   {
     return $this->amountBet;
   }
   
   /**
    * Easy-to-read representation of the Bet
    *
    * @return string
    */
   public function __toString()
   {
     return "{$this->amountBet} on {$this->outcome->getName()}";
   }
   
   /**
    * Easy-to-read representation of the Bet using another format
    *
    * @return string
    */
   public function representation()
   {
     return "Bet({$this->amount}, {$this->outcome->getName()})";
   }
   
   /**
    * Bet Outcome Getter
    *
    * @return Outcome
    */
   public function getOutcome()
   {
     return $this->outcome;
   }
}