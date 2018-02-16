<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Roulette\Outcome;
use Roulette\Bin;

/**
 * The unit test should create several instances of Outcome, two instances of 
 * Bin and establish that Bins can be constructed from the Outcomes.
 */
final class BinTest extends TestCase
{
  
  public function testCanConstructBinfromOutcomes()
  {
    $five = new Outcome('00-0-1-2-3', 6);
    $zero = new Outcome('0', 35);
    $zerozero = new Outcome('00', 35);
    
    $zeroBin = new Bin([
      $five,
      $zero
    ]);
    
    $zerozeroBin = new Bin([
      $five,
      $zerozero
    ]);
    
    $this->assertTrue($zeroBin->hasValue($five));
    $this->assertTrue($zeroBin->hasValue($zero));
    $this->assertFalse($zeroBin->hasValue($zerozero));
    
    $this->assertTrue($zerozeroBin->hasValue($five));
    $this->assertTrue($zerozeroBin->hasValue($zerozero));
    $this->assertFalse($zerozeroBin->hasValue($zero));
  }
  
}