<?php
declare(strict_types=1);

namespace Roulette;

use Exception;

/**
 * Is raised when the Player attempts to place a bet which exceeds the table’s limit.
 */
class InvalidBetException extends Exception
{  
  
}
