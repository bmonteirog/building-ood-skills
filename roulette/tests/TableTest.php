<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\Bet;
use Roulette\Table;
use Roulette\Outcome;

/**
 * The unit test should create at least two instances of Bet,
 * and establish that these Bet s are managed by the table correctly.
 */
final class TableTest extends TestCase
{
  
  public function testCanPlaceBet()
  {
    $five = new Outcome('Five bet', 6);
    $zero = new Outcome('0', 35);
    
    $bet1 = new Bet(16, $five);
    $bet2 = new Bet(34, $zero);
    
    $table = new Table();
    
    $this->assertTrue($table->placeBet($bet1) > 0);
    $this->assertTrue($table->placeBet($bet2) > 0);
  }
  
}