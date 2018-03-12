<?php
declare(strict_types=1);

namespace Roulette;

/**
 * Exercises the Roulette simulation with a given Player placing bets.
 * It reports raw statistics on a number of sessions of play.
 */
class Simulator
{

    /**
     * The duration value to use when initializing a 
     * Player for a session
     * 
     * @var int
     */
    protected $initDuration = 250;

    /**
     * The stake value to use when initializing a 
     * Player for a session
     * 
     * @var int
     */
    protected $initStake = 500;

    /**
     * The number of game cycles to simulate
     * 
     * @var int
     */
    protected $samples = 50;

    /**
     * @var IntegerStatistics
     */
    public $stats;

    /**
     * Essentially, the betting strategy we are simulating
     * 
     * @var Player
     */
    protected $player;

    /**
     * The casino game we are simulating.
     * 
     * @var Game
     */
    protected $game;

    /**
     * Simulator constructor
     */
    public function __construct(Game $game, Player $player)
    {
        $this->stats = new IntegerStatistics();

        $this->game = $game;
        $this->player = $player;
        $this->durations = [];
        $this->maxima = [];
    }

    /**
     * Executes a single game session. The Player is initialized with their initial stake and initial cycles to go.
     * An empty List of stake values is created. The session loop executes until the Player playing() returns false. 
     * This loop executes the Game cycle(); then it gets the stake from the Player and appends this amount to the List
     * of stake values. The List of individual stake values is returned as the result of the session of play.
     * 
     * @return array
     */
    public function session()
    {
        $this->player->setStake($this->initStake);
        $this->player->setRoundsToGo($this->initDuration);
        $this->player->restartPlayer();

        $stakeValues = [];

        while ($this->player->isPlaying()) {
            $this->game->cycle($this->player);
            array_push($stakeValues, $this->player->getStake());
        }

        return $stakeValues;
    }

    /**
     * Executes the number of games sessions in samples. Each game session returns a List of stake values. 
     * When the session is over (either the play reached their time limit or their stake was spent), 
     * then the length of the session List and the maximum value in the session List are the resulting duration 
     * and maximum metrics. These two metrics are appended to the durations list and the maxima list. 
     * A client class will either display the durations and maxima raw metrics or produce statistical summaries.
     */
    public function gather()
    {
        for ($gameCounter = 0; $gameCounter < $this->samples; $gameCounter++) {
            $sessionList = $this->session();

            $this->stats->addDuration(sizeof($sessionList));
            $this->stats->addMaxima(max($sessionList));
        }
    }

}