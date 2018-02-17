<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roulette\Wheel;
use Roulette\Outcome;

/**
 * Tests the Wheel class by selecting “random” values from a Wheel object using 
 * a fixed seed value.
 */
final class WheelRngTest extends TestCase
{
  
  public function testCanGetOutcomeFromSeed()
  {
    $five = new Outcome('00-0-1-2-3', 6);
    $zero = new Outcome('0', 35);
    $zerozero = new Outcome('00', 35);
    
    $wheel = new Wheel();
    
    $wheel->addOutcome(0, $five);
    $wheel->addOutcome(0, $zero);
    $wheel->addOutcome(37, $five);
    $wheel->addOutcome(37, $zerozero);
    
    $selectedBin1 = $wheel->next(0);
    $selectedBin2 = $wheel->next(37);
    
    $this->assertTrue($selectedBin1->hasValue($five));
    $this->assertTrue($selectedBin1->hasValue($zero));
    $this->assertTrue($selectedBin2->hasValue($five));
    $this->assertTrue($selectedBin2->hasValue($zerozero));
  }
  
}