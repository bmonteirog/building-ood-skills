<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Passenger57 is a stub for our Player class. It constructs a Bet based on the 
 * Outcome named "Black".
 */
class Passenger57 extends Player
{
  
  /**
   * Outcome that this player will bet every time
   *
   * @var Outcome
   */
  protected $black;
  
  /**
   * Table used to place Bets
   *
   * @var Table
   */
  protected $table;
  
  /**
   * Player available money
   *
   * @var int
   */
  protected $money;
  
  /**
  * Construct Passenger57 class
  *
  * @param Table
  * @param Wheel
  */
  public function __construct(Table $table, Wheel $wheel)
  {    
    $binBuilder = new BinBuilder();
    
    $this->money = 500;
    $this->table = $table;    
    $this->wheel = $binBuilder->buildBins($wheel);
    $this->black = $this->wheel->getOutcome("Black");
  }
  
  /**
   * Updates the Table with the various bets.
   */
  public function placeBets()
  {
    $betAmount = 15;
    $this->money = $this->money - $betAmount;
    
    $bet = new Bet($betAmount, $this->black);
    $this->table->placeBet($bet);
  }
  
  /**
   * Notification from the Game that the Bet was a winner
   *
   * @param Bet
   */
  public function win(Bet $bet)
  {
    $this->money = $this->money + $bet->winAmount();
  }
  
  /**
   * Notification from the Game that the Bet was a loser.
   *
   * @param Bet
   */
  public function lose(Bet $bet)
  {
    $this->money = $this->money - $bet->loseAmount();
  }
  
  /**
   * Player money getter
   *
   * @return int
   */
  public function getMoney()
  {
    return $this->money;
  }
  
}