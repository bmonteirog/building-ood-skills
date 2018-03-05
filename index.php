<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Simulator;
use Roulette\Passenger57;
use Roulette\MartingalePlayer;
use Roulette\Table;
use Roulette\BinBuilder;
use Roulette\Wheel;
use Roulette\Game;
use Roulette\Outcome;


$binBuilder = new BinBuilder();
$table = new Table($binBuilder->buildBins(new Wheel()));
$player = new MartingalePlayer($table);
$player->setAmount(10);
$player->outcome = new Outcome("Red", 1);
$game = new Game($table->wheel, $table);
$simulator = new Simulator($game, $player);

$simulator->gather();

print_r($simulator->durations);
print_r($simulator->maxima);