<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roulette\Outcome;

/**
 * The unit test should create three instances of Outcome, two of which have 
 * the same name. It should use a number of individual tests to establish that 
 * two Outcome with the same name will test true for equality, have the same 
 * hash code, and establish that the winAmount() method works correctly.
 */
final class OutcomeTest extends TestCase
{
  
  public function testTwoOutcomesSameNameAreEqual()
  {
    $outcome1 = new Outcome('1-2 Split', 17);
    $outcome2 = new Outcome('1-2 Split', 17);
    $outcome3 = new Outcome('Corner 1-2-4-5', 8);
    
    $this->assertTrue($outcome1->equals($outcome2));
    $this->assertFalse($outcome1->equals($outcome3));
    $this->assertTrue($outcome1->getHash() === $outcome2->getHash());
    $this->assertFalse($outcome1->getHash() === $outcome3->getHash());
  }
  
  public function testWinAmount()
  {
    $outcome1 = new Outcome('1-2 Split', 17);
    $outcome2 = new Outcome('Corner 1-2-4-5', 8);
    
    $this->assertTrue($outcome1->winAmount(1) == 17);
    $this->assertTrue($outcome1->winAmount(6) == 102);
    $this->assertTrue($outcome2->winAmount(1) == 8);
    $this->assertTrue($outcome2->winAmount(9) == 72);
  }
  
}