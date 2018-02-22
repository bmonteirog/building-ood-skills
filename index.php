<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Passenger57;
use Roulette\Table;
use Roulette\Wheel;

$player = new Passenger57(new Table, new Wheel);