<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Roulette\InvalidBetException;

/**
 * Testing if this class works with the raise statement. Failure to extend 
 * Exception would lead to a program that more-or-less worked until a faulty 
 * Player class caused the invalid bet situation.
 */
final class InvalidBetExceptionTest extends TestCase
{
  
    public function testCanThrowException() 
    {
      $this->expectException(InvalidBetException::class);
      
      throw new InvalidBetException("Invalid Bet", 1);
      
    }
  
}