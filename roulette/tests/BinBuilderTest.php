<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Roulette\Wheel;
use Roulette\Outcome;
use Roulette\BinBuilder;

/**
 * The unit test should create several instances of Outcome, two instances of 
 * Bin and establish that Bins can be constructed from the Outcomes.
 */
final class BinBuilderTest extends TestCase
{
  
  protected $wheel;
  
  protected $outcomes;
  
  protected $bin;
  
  protected function setUp()
  {
    $wheel = new Wheel();
    $binBuilder = new BinBuilder();
    
    $this->wheel = $binBuilder->buildBins($wheel);
    
    $this->outcomes[0] = [
      'straight' => new Outcome('0', 35),
      'split' => [],
      'street' => '',
    ];
    
    $this->outcomes[12] = [
      'straight' => new Outcome('12', 35),
      'split' => [
        new Outcome('Split 11-12', 17),
        new Outcome('Split 9-12', 17),
        new Outcome('Split 12-15', 17)
      ],
      'street' => new Outcome('Street 10-11-12', 11),
    ];
    
    $this->outcomes[21] = [
      'straight' => new Outcome('21', 35),
      'split' => [
        new Outcome('Split 20-21', 17),
        new Outcome('Split 18-21', 17),
        new Outcome('Split 21-24', 17)
      ],
      'street' => new Outcome('Street 19-20-21', 11),
    ];
    
    $this->outcomes[28] = [
      'straight' => new Outcome('28', 35),
      'split' => [
        new Outcome('Split 25-28', 17),
        new Outcome('Split 28-29', 17),
        new Outcome('Split 28-31', 17)
      ],
      'street' => new Outcome('Street 28-29-30', 11),
    ];
    
    /*
      Will output the sequence:
      28, 12, 21, 0, 5, 37, 20, 27, 33, 13
    */     
    srand(111);
    
    $this->bin[0] = $this->wheel->next(); // 28
    $this->bin[1] = $this->wheel->next(); // 12
    $this->bin[2] = $this->wheel->next(); // 21
    $this->bin[3] = $this->wheel->next(); // 0
  }
  
  public function testCanBuildStraightBets()
  {  
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['straight']));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['straight']));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['straight']));
    $this->assertTrue($this->bin[3]->hasOutcome($this->outcomes[0]['straight']));
  }
  
  public function testCanBuildSplitBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['split'][0]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['split'][1]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['split'][2]));
    
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['split'][0]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['split'][1]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['split'][2]));
    
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['split'][0]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['split'][1]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['split'][2]));        
  }
  
  public function testCanBuildStreetBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['street']));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['street']));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['street']));
  }
  
}