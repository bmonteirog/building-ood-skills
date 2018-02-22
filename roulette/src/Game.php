<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Game manages the sequence of actions that defines the game of Roulette.
 */
class Game
{
  
  /**
   * @var Wheel
   */
   protected $wheel;
   
  /**
   * @var Table
   */
  protected $table;
    
  /**
   * @var Player
   */
  protected $player;
  
  /**
   * Constructs a new Game, using a given Wheel and Table.
   *
   * @param Wheel
   * @param Table
   */
  public function __construct(Wheel $wheel, Table $table)
  {
    $this->wheel = $wheel;
    $this->table = $table;
  }
  
  /**
  * This will execute a single cycle of play with a given Player.
  *
  * @param Player
  *
  */
  public function cycle(Player $player)
  {
    $player->placeBets();
    
    $winningBin = $this->wheel->next();
    
    foreach ($this->table->getBets() as $bet) {
      if ($winningBin->hasOutcome($bet->getOutcome())) {
        $player->win($bet);        
      } else {
        $player->lose($bet);
      }
    }
  }
  
}