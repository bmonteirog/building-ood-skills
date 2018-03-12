<?php
declare(strict_types=1);

namespace Roulette;

/**
 * 
 */
class IntegerStatistics
{

    /**
     * A List of lengths of time the Player remained in the game
     * 
     * @var int[]
     */
    protected $durationList = [];

    /**
     * A List of maximum stakes for each Player
     * 
     * @var int[]
     */    
    protected $maximaList = [];

    /**
     * Add a integer value to durations list
     * 
     * @param int $duration
     */
    public function addDuration(int $duration)
    {
        array_push($this->durationList, $duration);
    }

    /**
     * Add a integer value to maximas list
     * 
     * @param int $maxima
     */    
    public function addMaxima(int $maxima)
    {
        array_push($this->maximaList, $maxima);
    }

    /**
     * Calculates the mean of a given integer array
     * 
     * @param int[] $list
     * 
     * @return int
     */
    public function mean(array $list)
    {
        return array_sum($list) / count($list);
    }

    /**
     * Calculates the standard deviation of a given integer array
     * 
     * @param int[] $list
     * 
     * @return float
     */
    public function standardDeviation(array $list)
    {
        $mean = $this->mean($list);
        $listLength = count($list);
        $sum = 0;

        for ($i = 0; $i < $listLength; $i++) { 
            $sum += ($list[$i] - $mean) ** 2;
        }

        $stdDev = sqrt($sum/($listLength - 1));

        return round($stdDev, 2);
    }

    /**
     * Print results
     */
    public function results()
    {
        $result  = "Maxima \n";
        $result .= "Mean: {$this->mean($this->maximaList)} \n";
        $result .= "Std. Deviation: {$this->standardDeviation($this->maximaList)} \n";
        $result .= "----------- \n";
        $result .= "Duration \n";
        $result .= "Mean: {$this->mean($this->durationList)} \n";
        $result .= "Std. Deviation: {$this->standardDeviation($this->durationList)} \n";
        $result .= "----------- \n\n";

        return $result;
    }
}