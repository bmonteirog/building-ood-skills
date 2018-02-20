<?php
declare(strict_types=1);

namespace Roulette;

use Roulette\Wheel;
use Roulette\Outcome;

/**
 * Builds bins results and associates with Outcomes
 */
class BinBuilder
{

  /**
   * @var Wheel
   */
   protected $wheel;

  /**
   * Wheel that must be populated with Outcomes
   *
   * @param Wheel
   *
   * @return Wheel
   */
  public function buildBins(Wheel $wheel)
  {
    $this->wheel = $wheel;

    $this->generateStraightBets();
    $this->generateSplitBets();
    $this->generateStreetBets();
    $this->generateCornerBets();
    $this->generateLineBets();
    $this->generateDozenBets();
    $this->generateColumnBets();
    $this->generateEvenMoneyBets();
    $this->generateFiveBet();

    return $this->wheel;
  }

  /**
   * Create all straight bets possible for the wheel
   **/
  private function generateStraightBets()
  {
    for ($i = 0; $i <= 37; $i++) {
      $outcomeName = ($i < 37) ? "{$i}" : "00";
      $this->wheel->addOutcome($i, new Outcome($outcomeName, 35));
    }
  }

  /**
   * Create all split bets possible for the wheel
   **/
  private function generateSplitBets()
  {
    for ($row = 0; $row < 12; $row++) {
      $this->createLeftRightSplits($row);
    }

    for ($number = 1; $number <= 33; $number++) {
      $this->createUpDownSplits($number);
    }
  }

  /**
   * Create left-right splits for the columns 1 and 2
   **/
  private function createLeftRightSplits(int $row)
  {
    $firstColumnNumber = (3 * $row) + 1;
    $neighbor = $firstColumnNumber + 1;
    $firstColumnSplitOutcome = new Outcome("Split {$firstColumnNumber}-{$neighbor}", 17);
    $this->wheel->addOutcome($firstColumnNumber, $firstColumnSplitOutcome);
    $this->wheel->addOutcome($neighbor, $firstColumnSplitOutcome);

    $secondColumnNumber = (3 * $row) + 2;
    $secondNeighbor = $secondColumnNumber + 1;
    $secondColumnSplitOutcome = new Outcome("Split {$secondColumnNumber}-{$secondNeighbor}", 17);
    $this->wheel->addOutcome($secondColumnNumber, $secondColumnSplitOutcome);
    $this->wheel->addOutcome($secondNeighbor, $secondColumnSplitOutcome);
  }

  /**
   * Create up-down splits
   **/
  private function createUpDownSplits(int $number)
  {
    $neighbor = $number + 3;
    $splitOutcome = new Outcome("Split {$number}-{$neighbor}", 17);
    $this->wheel->addOutcome($number, $splitOutcome);
    $this->wheel->addOutcome($neighbor, $splitOutcome);
  }

  /**
   * Create all street bets possible for the wheel
   **/
  private function generateStreetBets()
  {
    for ($row = 0; $row < 12; $row++) {
      $firstNumber = (3 * $row) + 1;
      $secondNumber = $firstNumber + 1;
      $thirdNumber = $firstNumber + 2;
      $streetOutcome = new Outcome("Street {$firstNumber}-{$secondNumber}-{$thirdNumber}", 11);
      $this->wheel->addOutcome($firstNumber, $streetOutcome);
      $this->wheel->addOutcome($secondNumber, $streetOutcome);
      $this->wheel->addOutcome($thirdNumber, $streetOutcome);
    }
  }

  /**
   * Create all corner bets possible for the wheel
   **/
  private function generateCornerBets()
  {
    for ($row = 0; $row < 11; $row++) {
      $firstColNumber = (3 * $row) + 1;
      $firstColRightNeighbor = $firstColNumber + 1;
      $firstColDownNeighbor = $firstColNumber + 3;
      $firstColDownRightNeighbor = $firstColNumber + 4;
      $firstColCornerOutcome = new Outcome("Corner {$firstColNumber}-{$firstColRightNeighbor}-{$firstColDownNeighbor}-{$firstColDownRightNeighbor}", 8);
      $this->wheel->addOutcome($firstColNumber, $firstColCornerOutcome);
      $this->wheel->addOutcome($firstColRightNeighbor, $firstColCornerOutcome);
      $this->wheel->addOutcome($firstColDownNeighbor, $firstColCornerOutcome);
      $this->wheel->addOutcome($firstColDownRightNeighbor, $firstColCornerOutcome);

      $secondColNumber = (3 * $row) + 2;
      $secondColRightNeighbor = $secondColNumber + 1;
      $secondColDownNeighbor = $secondColNumber + 3;
      $secondColDownRightNeighbor = $secondColNumber + 4;
      $secondColCornerOutcome = new Outcome("Corner {$secondColNumber}-{$secondColRightNeighbor}-{$secondColDownNeighbor}-{$secondColDownRightNeighbor}", 8);
      $this->wheel->addOutcome($secondColNumber, $secondColCornerOutcome);
      $this->wheel->addOutcome($secondColRightNeighbor, $secondColCornerOutcome);
      $this->wheel->addOutcome($secondColDownNeighbor, $secondColCornerOutcome);
      $this->wheel->addOutcome($secondColDownRightNeighbor, $secondColCornerOutcome);
    }
  }

  /**
   * Create all line bets possible for the wheel
   **/
  private function generateLineBets()
  {
    for ($row = 0; $row < 11; $row++) {
      $number = (3 * $row) + 1;
      $rightNeighbor = $number + 1;
      $rightRightNeighbor = $number + 2;
      $downNeighbor = $number + 3;
      $downRightNeighbor = $number + 4;
      $downRightRightNeighbor = $number + 5;
      $lineOutcome = new Outcome("Line {$number}-{$rightNeighbor}-{$rightRightNeighbor}-{$downNeighbor}-{$downRightNeighbor}-{$downRightRightNeighbor}", 5);
      $this->wheel->addOutcome($number, $lineOutcome);
      $this->wheel->addOutcome($rightNeighbor, $lineOutcome);
      $this->wheel->addOutcome($rightRightNeighbor, $lineOutcome);
      $this->wheel->addOutcome($downNeighbor, $lineOutcome);
      $this->wheel->addOutcome($downRightNeighbor, $lineOutcome);
      $this->wheel->addOutcome($downRightRightNeighbor, $lineOutcome);
    }
  }

  /**
   * Create all dozen bets possible for the wheel
   **/
  private function generateDozenBets()
  {
    for ($dozen = 0; $dozen < 3; $dozen++) {
      $dozenNumber = $dozen + 1;
      $dozenOutcome = new Outcome("Dozen {$dozenNumber}", 2);
      for ($numberCounter = 0; $numberCounter < 12; $numberCounter++) {
        $number = (12 * $dozen) + $numberCounter + 1;
        $this->wheel->addOutcome($number, $dozenOutcome);
      }
    }
  }

  /**
   * Create all column possible for the wheel
   **/
  private function generateColumnBets()
  {
    for ($column = 0; $column < 3; $column++) {
      $columnNumber = $column + 1;
      $columnOutcome = new Outcome("Column {$columnNumber}", 2);
      for ($row = 0; $row < 12; $row++) {
        $number = (3 * $row) + $column + 1;
        $this->wheel->addOutcome($number, $columnOutcome);
      }
    }
  }

  /**
   * Create all split even money possible for the wheel
   **/
  private function generateEvenMoneyBets()
  {
    $redOutcome = new Outcome("Red", 1);
    $blackOutcome = new Outcome("Black", 1);
    $evenOutcome = new Outcome("Even", 1);
    $oddOutcome = new Outcome("Odd", 1);
    $highOutcome = new Outcome("High", 1);
    $lowOutcome = new Outcome("Low", 1);

    for ($number=1; $number < 37; $number++) {
      if ($this->isLow($number)) {
        $this->wheel->addOutcome($number, $lowOutcome);
      } else {
        $this->wheel->addOutcome($number, $highOutcome);
      }
      if ($this->isEven($number)) {
        $this->wheel->addOutcome($number, $evenOutcome);
      } else {
        $this->wheel->addOutcome($number, $oddOutcome);
      }
      if ($this->isRed($number)) {
        $this->wheel->addOutcome($number, $redOutcome);
      } else {
        $this->wheel->addOutcome($number, $blackOutcome);
      }
    }
  }

  /**
   * Checks if a given number is under 19
   *
   * @return bool
   */
  private function isLow($number)
  {
    return $number < 19;
  }

  /**
   * Checks if a given number is even
   *
   * @return bool
   */
  private function isEven($number)
  {
    return $number%2 == 0;
  }

  /**
   * Checks if a given number is red
   *
   * @return bool
   */
  private function isRed($number)
  {
    $reds = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];
    return in_array($number, $reds);
  }

  /**
   * Create bets for the Five Bet
   **/
  private function generateFiveBet()
  {
    $fiveOutcome = new Outcome("Five bet", 6);
    $this->wheel->addOutcome(0, $fiveOutcome);
    $this->wheel->addOutcome(1, $fiveOutcome);
    $this->wheel->addOutcome(2, $fiveOutcome);
    $this->wheel->addOutcome(3, $fiveOutcome);
    $this->wheel->addOutcome(37, $fiveOutcome);
  }


}
