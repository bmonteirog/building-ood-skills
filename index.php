<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Outcome;
use Roulette\Bin;

srand(7);
for ($i=0; $i < 10; $i++) {
  echo rand(0,38) . ', ';
}
