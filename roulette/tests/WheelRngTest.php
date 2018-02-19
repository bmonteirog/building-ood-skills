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
    
    // Will output the sequence 18, 32, 22, 8, 0, 19, 37
    srand(7);
    
    $selectedBin1 = $wheel->next(); // 18
    $selectedBin2 = $wheel->next(); // 32
    $selectedBin3 = $wheel->next(); // 22
    $selectedBin4 = $wheel->next(); // 8
    $selectedBin5 = $wheel->next(); // 0
    $selectedBin6 = $wheel->next(); // 19
    $selectedBin7 = $wheel->next(); // 37
    
    $this->assertFalse($selectedBin1->hasValue($five));
    $this->assertFalse($selectedBin1->hasValue($zero));
    
    $this->assertFalse($selectedBin2->hasValue($five));
    $this->assertFalse($selectedBin2->hasValue($zero));
    
    $this->assertFalse($selectedBin3->hasValue($five));
    $this->assertFalse($selectedBin3->hasValue($zero));
    
    $this->assertFalse($selectedBin4->hasValue($five));
    $this->assertFalse($selectedBin4->hasValue($zero));
    
    $this->assertTrue($selectedBin5->hasValue($five));
    $this->assertTrue($selectedBin5->hasValue($zero));
    
    $this->assertFalse($selectedBin6->hasValue($five));
    $this->assertFalse($selectedBin6->hasValue($zero));
    
    $this->assertTrue($selectedBin7->hasValue($five));
    $this->assertTrue($selectedBin7->hasValue($zerozero));
  }
  
}