<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\{
  Bin,
  Outcome
};

/**
 * The unit test should create several instances of Outcome, two instances of 
 * Bin and establish that Bins can be constructed from the Outcomes.
 */
final class BinTest extends TestCase
{

  protected $five;

  protected $zero;

  protected $zerozero;

  public function setUp()
  {
    $this->five = new Outcome('00-0-1-2-3', 6);
    $this->zero = new Outcome('0', 35);
    $this->zerozero = new Outcome('00', 35);
  }
  
  public function testCanConstructBinfromOutcomes()
  { 
    $zeroBin = new Bin([
      $this->five,
      $this->zero
    ]);
    
    $zerozeroBin = new Bin([
      $this->five,
      $this->zerozero
    ]);
    
    $this->assertTrue($zeroBin->hasValue($this->five));
    $this->assertTrue($zeroBin->hasValue($this->zero));
    $this->assertFalse($zeroBin->hasValue($this->zerozero));
    
    $this->assertTrue($zerozeroBin->hasValue($this->five));
    $this->assertTrue($zerozeroBin->hasValue($this->zerozero));
    $this->assertFalse($zerozeroBin->hasValue($this->zero));
  }
  
  public function testCanGetAllOutcomesFromBin()
  {
    $outcomes = [
      $this->five,
      $this->zerozero
    ];

    $zerozeroBin = new Bin($outcomes);

    $this->assertEquals($zerozeroBin->getAllOutcomes(), $outcomes);
  }
}