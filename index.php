<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Simulator;
use Roulette\MartingalePlayer;
use Roulette\Table;
use Roulette\Wheel;
use Roulette\Game;


$table = new Table(new Wheel());
$player = new MartingalePlayer($table);
$player->setAmount(10);
$game = new Game($table->wheel, $table);
$simulator = new Simulator($game, $player);

$simulator->gather();

print_r($simulator->durations);
print_r($simulator->maxima);