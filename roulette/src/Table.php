<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Has the responsibility to Keep the Bets created by the Player
 * A table also has a betting limit, and the sum of all of a player’s
 * bets must be less than or equal to this limit
 */
class Table
{
  
  /**
   * @var int
   */
  protected $limit;
  
  /**
   * @var int
   */
  protected $minimum;
  
  /**
   * @var Bet[]
   */
  protected $bets;
  
  /**
   * Table constructor
   */  
  public function __construct()
  {
    $this->bets = [];
  }
  
  /**
   * Add a Bet to the Table
   *
   * @param Bet
   *
   * @return int
   */
  public function placeBet(Bet $bet)
  {
    return array_push($this->bets, $bet);
  }
  
  /**
  * Return Bets array
  *
  * @return Bet[]
  */
  public function getBets()
  {
    return $this->bets;
  }
  
  /**
   * Check if all bets pass the table limit rules
   *
   * @throws InvalidBetException   
   */
  public function isValid()
  {
    foreach ($this->bets as $bet) {
      if (!$this->validateBet($bet)) {
        throw new InvalidBetException("Invalid Bet", 1);        
      }
    }
  }
  
  /**
   * Check if a single bet pass the validation rules
   *
   * @param Bet
   *
   * @return bool
   */
  private function validateBet(Bet $bet)
  {
    
  }
  
}
