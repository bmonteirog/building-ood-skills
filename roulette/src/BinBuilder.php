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
    $this->generateZeroBets();
    $this->generateDoubleZeroBets();
    
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
    
  }
  
  /**
   * Create all line bets possible for the wheel
   **/
  private function generateLineBets() 
  {
    
  }
  
  /**
   * Create all dozen bets possible for the wheel
   **/
  private function generateDozenBets() 
  {
    
  }
  
  /**
   * Create all column possible for the wheel
   **/
  private function generateColumnBets() 
  {
    
  }
  
  /**
   * Create all split even money possible for the wheel
   **/
  private function generateEvenMoneyBets() 
  {
    
  }
  
  /**
   * Create bets for the Zero Bin
   **/
  private function generateZeroBets() 
  {
    
  }
  
  /**
   * Create bets for the Double Zero Bin
   **/
  private function generateDoubleZeroBets() 
  {
    
  }

}  