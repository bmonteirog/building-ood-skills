<?php
declare(strict_types=1);

namespace Roulette;

/**
 * This Factory can retain a small pool of object 
 * instances, eliminating needless object construction.
 */
class Player1326StateFactory
{

    /**
     * This is a map from a class name to an object instance.
     * 
     * @var Player1326State[]
     */
    protected $values;

    /**
     * Player Instance
     * 
     * @var Player1326
     */
    protected $player;

    /**
     * Create a new mapping from the class name to object instance. 
     * There are only four objects, so this is relatively simple.
     */
    public function __construct($player)
    {
        $this->player = $player;
    }

    /**
     * Returns Player1326 State
     * 
     * @param string $name
     * 
     * @return Player1326State
     */
    public function get(string $name)
    {
        if (!isset($this->values[$name])) {
            $this->values[$name] = new $name($this->player);
        }

        return $this->values[$name];
    }

}