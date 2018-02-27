<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Wheel,
  Outcome
};


/**
 * The unit test should create several instances of Outcome, two instances of 
 * Bin, and an instance of Wheel. The unit test should establish that Bins can 
 * be added to the Wheel.
 */
final class WheelTest extends TestCase
{
  
  public function testCanAddOutcomeToWheel()
  {
    $five = new Outcome('Five bet', 6);
    $zero = new Outcome('0', 35);
    $zerozero = new Outcome('00', 35);
    
    $wheel = new Wheel();
    
    $this->assertTrue($wheel->addOutcome(0, $five));
    $this->assertTrue($wheel->addOutcome(0, $zero));
    $this->assertTrue($wheel->addOutcome(37, $five));
    $this->assertTrue($wheel->addOutcome(37, $zerozero));
  }
  
  public function testCanCreateOutcomeMapping()
  {
    $five = new Outcome('Five bet', 6);
    $zero = new Outcome("0", 35);
    $zerozero = new Outcome("00", 35);
    
    $wheel = new Wheel();
    
    $wheel->addOutcome(0, $five);
    $wheel->addOutcome(0, $zero);
    $wheel->addOutcome(37, $zerozero);
    
    $this->assertTrue($wheel->getOutcome('Five bet')->equals($five));
    $this->assertTrue($wheel->getOutcome('0')->equals($zero));
    $this->assertTrue($wheel->getOutcome('00')->equals($zerozero));
  }
  
}