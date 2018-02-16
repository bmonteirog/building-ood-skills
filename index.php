<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Outcome;
use Roulette\Bin;

$five = new Outcome('00-0-1-2-3', 6);

// Outcomes: 0 and 00-0-1-2-3
$zero = new Bin([
  new Outcome('0', 35),
  $five
]);

// Outcomes: 00 and 00-0-1-2-3
$zerozero = new Bin([
  new Outcome('00', 35),
  $five
]);

var_dump($zero);
var_dump($zerozero);
