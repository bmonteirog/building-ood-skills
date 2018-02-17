<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roulette\Wheel;
use Roulette\Outcome;

/**
 * The unit test should create several instances of Outcome, two instances of 
 * Bin, and an instance of Wheel. The unit test should establish that Bins can 
 * be added to the Wheel.
 */
final class WheelTest extends TestCase
{
  
  public function testCanAddOutcomeToWheel()
  {
    $five = new Outcome('00-0-1-2-3', 6);
    $zero = new Outcome('0', 35);
    $zerozero = new Outcome('00', 35);
    
    $wheel = new Wheel();
    
    $this->assertTrue($wheel->addOutcome(0, $five));
    $this->assertTrue($wheel->addOutcome(0, $zero));
    $this->assertTrue($wheel->addOutcome(37, $five));
    $this->assertTrue($wheel->addOutcome(37, $zerozero));
  }
  
}