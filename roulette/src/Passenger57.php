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
  * Construct Passenger57 class
  *
  * @param Table  
  */
  public function __construct(Table $table)
  { 
    parent::__construct($table);
    
    $this->black = $table->wheel->getOutcome("Black");
  }
  
  /**
   * Updates the Table with the various bets.
   */
  public function placeBets()
  {
    $bet = new Bet($this->amount, $this->black);
    $this->table->placeBet($bet);
  }

  /**
   * The game will notify a player of each spin using this method.
   * 
   * @param Bin $winningBin
   */
  public function winners(Bin $winningBin)
  {

  }

  /**
   * Restart player's vars
   */
  public function restartPlayer()
  {
    $this->setRoundsPlayed(0);
  }
}