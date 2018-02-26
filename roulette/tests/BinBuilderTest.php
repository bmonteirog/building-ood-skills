<?php
declare(strict_types=1);

namespace Roulette\Tests;

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
      'street' => null,
      'corner' => null,
      'line' => null,
      'dozen' => null,
      'column' => null,
      'evenMoney' => null,
      'fiveBet' => new Outcome("Five bet", 6)
    ];

    $this->outcomes[12] = [
      'straight' => new Outcome('12', 35),
      'split' => [
        new Outcome('Split 11-12', 17),
        new Outcome('Split 9-12', 17),
        new Outcome('Split 12-15', 17)
      ],
      'street' => new Outcome('Street 10-11-12', 11),
      'corner' => [
        new Outcome('Corner 8-9-11-12', 8),
        new Outcome('Corner 11-12-14-15', 8),
      ],
      'line' => [
        new Outcome('Line 7-8-9-10-11-12', 5),
        new Outcome('Line 10-11-12-13-14-15', 5),
      ],
      'dozen' => new Outcome('Dozen 1', 2),
      'column' => new Outcome('Column 3', 2),
      'evenMoney' => [
        new Outcome('Low', 1),
        new Outcome('Red', 1),
        new Outcome('Even', 1),
      ],
      'fiveBet' => null
    ];

    $this->outcomes[21] = [
      'straight' => new Outcome('21', 35),
      'split' => [
        new Outcome('Split 20-21', 17),
        new Outcome('Split 18-21', 17),
        new Outcome('Split 21-24', 17)
      ],
      'street' => new Outcome('Street 19-20-21', 11),
      'corner' => [
        new Outcome('Corner 17-18-20-21', 8),
        new Outcome('Corner 20-21-23-24', 8),
      ],
      'line' => [
        new Outcome('Line 16-17-18-19-20-21', 5),
        new Outcome('Line 19-20-21-22-23-24', 5),
      ],
      'dozen' => new Outcome('Dozen 2', 2),
      'column' => new Outcome('Column 3', 2),
      'evenMoney' => [
        new Outcome('High', 1),
        new Outcome('Red', 1),
        new Outcome('Odd', 1),
      ],
      'fiveBet' => null
    ];

    $this->outcomes[28] = [
      'straight' => new Outcome('28', 35),
      'split' => [
        new Outcome('Split 25-28', 17),
        new Outcome('Split 28-29', 17),
        new Outcome('Split 28-31', 17)
      ],
      'street' => new Outcome('Street 28-29-30', 11),
      'corner' => [
        new Outcome('Corner 25-26-28-29', 8),
        new Outcome('Corner 28-29-31-32', 8),
      ],
      'line' => [
        new Outcome('Line 25-26-27-28-29-30', 5),
        new Outcome('Line 28-29-30-31-32-33', 5),
      ],
      'dozen' => new Outcome('Dozen 3', 2),
      'column' => new Outcome('Column 1', 2),
      'evenMoney' => [
        new Outcome('High', 1),
        new Outcome('Black', 1),
        new Outcome('Even', 1),
      ],
      'fiveBet' => null
    ];

    $rngStub = $this->createMock(\Clickalicious\Rng\Generator::class);
    $rngStub->method('generate')->will($this->onConsecutiveCalls(28, 12, 21, 0, 5, 37, 20, 27, 33, 13));
    $wheel->rng = $rngStub;

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

  public function testCanBuildCornerBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['corner'][0]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['corner'][1]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['corner'][0]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['corner'][1]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['corner'][0]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['corner'][1]));
  }

  public function testCanBuildLineBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['line'][0]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['line'][1]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['line'][0]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['line'][1]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['line'][0]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['line'][1]));
  }

  public function testCanBuildDozenBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['dozen']));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['dozen']));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['dozen']));
  }

  public function testCanBuildColumnBet()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['column']));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['column']));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['column']));
  }

  public function testCanBuildEvenMoneyBets()
  {
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['evenMoney'][0]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['evenMoney'][1]));
    $this->assertTrue($this->bin[0]->hasOutcome($this->outcomes[28]['evenMoney'][2]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['evenMoney'][0]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['evenMoney'][1]));
    $this->assertTrue($this->bin[1]->hasOutcome($this->outcomes[12]['evenMoney'][2]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['evenMoney'][0]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['evenMoney'][1]));
    $this->assertTrue($this->bin[2]->hasOutcome($this->outcomes[21]['evenMoney'][2]));
  }

  public function testCanBuildFiveBet()
  {
    $this->assertTrue($this->bin[3]->hasOutcome($this->outcomes[0]['fiveBet']));
  }
}
