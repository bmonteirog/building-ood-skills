<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Bet,
  Table,
  Outcome,
  Wheel,
  InvalidBetException
};


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
    
    $table = new Table(new Wheel());
    
    $this->assertTrue($table->placeBet($bet1) > 0);
    $this->assertTrue($table->placeBet($bet2) > 0);
  }
  
  public function testCanThrowExceptionOnInvalidBet()
  {
    $this->expectException(InvalidBetException::class);

    $five = new Outcome('Five bet', 6);
    $bet = new Bet(16000000000, $five);
    $table = new Table(new Wheel());
    $table->placeBet($bet);
  }
}