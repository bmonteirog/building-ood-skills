<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\Outcome;
use Roulette\Bet;
use Roulette\MartingalePlayer;
use Roulette\Wheel;
use Roulette\Table;
use Roulette\BinBuilder;

/**
 * This test should synthesize a fixed list of Outcome s, Bin s, and calls a Martingale
 * instance with various sequences of reds and blacks to assure that the bet doubles 
 * appropriately on each loss, and is reset on each win.
 */
final class MartingalePlayerTest extends TestCase
{

  protected $outcomes;

  protected $player;

  public function setUp()
  {
    $this->outcomes['black'] = new Outcome('11', 35);
    $this->outcomes['red'] = new Outcome('27', 35);

    $binBuilder = new BinBuilder();    
    $table = new Table($binBuilder->buildBins(new Wheel()));
    $this->player = new MartingalePlayer($table);
  }
  
  public function testCanDoubleBets()
  {

  }

  public function testIsResetOnWin()
  {
      
  }

}