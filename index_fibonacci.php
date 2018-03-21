<?php

require __DIR__.'/vendor/autoload.php';

use Roulette\Simulator;
use Roulette\FibonacciPlayer as Player;
use Roulette\Table;
use Roulette\Wheel;
use Roulette\Game;


$table = new Table(new Wheel());
$player = new Player($table);
$player->setAmount(10);
$game = new Game($table->wheel, $table);
$simulator = new Simulator($game, $player);

$simulator->gather();

echo $simulator->stats->results();