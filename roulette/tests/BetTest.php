<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Bet,
  Outcome
};

/**
 * The unit test should create a couple instances of Outcome,
 * and establish that the winAmount() and loseAmount() methods work correctly.
 */
final class BetTest extends TestCase
{
  
  protected $outcomes;
  
  protected function setUp()
  {
    $this->outcomes['five'] = new Outcome('Five bet', 6);
    $this->outcomes['zero'] = new Outcome('0', 35);
    $this->outcomes['zerozero'] = new Outcome('00', 35);
  }
  
  public function testCanGetWinAmount()
  {  
    $bet1 = new Bet(10, $this->outcomes['five']);
    $bet2 = new Bet(7, $this->outcomes['zero']);
    $bet3 = new Bet(19, $this->outcomes['zerozero']);
    
    $this->assertTrue($bet1->winAmount() == 70);
    $this->assertTrue($bet2->winAmount() == 252);
    $this->assertTrue($bet3->winAmount() == 684);
  }
  
  public function testCanGetLoseAmount()
  {
    $bet1 = new Bet(3, $this->outcomes['five']);
    $bet2 = new Bet(70, $this->outcomes['zero']);
    $bet3 = new Bet(41, $this->outcomes['zerozero']);
    
    $this->assertTrue($bet1->loseAmount() == 3);
    $this->assertTrue($bet2->loseAmount() == 70);
    $this->assertTrue($bet3->loseAmount() == 41);
  }
  
}