<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

/**
 * This test should synthesize a fixed list of Outcome s, Bin s, and calls a Martingale
 * instance with various sequences of reds and blacks to assure that the bet doubles 
 * appropriately on each loss, and is reset on each win.
 */
final class MartingalePlayerTest extends TestCase
{
  
  public function testCanDoubleBets()
  {

  }

  public function testIsResetOnWin()
  {
      
  }

}