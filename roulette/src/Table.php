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
   * @var Bet[]
   */
  protected $bets;

  /**
   * @var Wheel
   */
  public $wheel;
  
  /**
   * Table constructor
   */  
  public function __construct(Wheel $wheel, int $limit = 5000)
  {
    $this->cleanBets();
    $this->wheel = $wheel;   
    $this->limit = $limit;
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
    $this->isValid($bet);
    
    return array_push($this->bets, $bet);
  }

  /**
   * Clean Tables Bets before next cycle
   */
  public function cleanBets()
  {
    $this->bets = [];
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
   * @param Bet $bet
   *
   * @throws InvalidBetException   
   */
  public function isValid(Bet $bet)
  {
    if (!$this->validateBets($bet)) {
      throw new InvalidBetException("Invalid Bet: " . $bet, 1);
    }
  }
  
  /**
   * Check if the bets respects Table's minimum and limit
   * 
   * @param Bet $bet
   *
   * @return bool
   */
  private function validateBets(Bet $bet)
  {
    $currentStake = $bet->getAmount();

    foreach ($this->bets as $placedBet) {
      $currentStake = $currentStake + $placedBet->getAmount();
    }

    $tooHigh = $currentStake > $this->limit;

    return !$tooHigh;
  }
  
}
