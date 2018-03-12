<?php
declare(strict_types=1);

namespace Roulette\Tests;

use PHPUnit\Framework\TestCase;

use Roulette\IntegerStatistics;

/**
 * Tests the Statistics Analysis Class
 */
final class IntegerStatisticsTest extends TestCase
{

    protected $stats;

    protected $values;

    public function setUp()
    {
        $this->stats = new IntegerStatistics();
        
        $this->values = [10,8,13,9,11,14,6,4,12,7,5];
    }
    
    public function testCanCalculateMean()
    {   
        $calculatedMean = 9;
        $this->assertEquals($this->stats->mean($this->values), $calculatedMean);
    }

    public function testCanCalculateStandardDeviation()
    {
        $calculatedStdDev = 3.32;
        $this->assertEquals($this->stats->standardDeviation($this->values), $calculatedStdDev);
    }

}