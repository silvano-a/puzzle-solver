<?php

namespace app\Solver;

use app\Game\GameConfig;
use app\Game\GameState;

final class Queue
{
    private $queue;

    private $seenStatesHashes = [];

    public $winner = null;

    private $iterations = -1;

    /**
     * @var GameConfig
     */
    private $gameConfig;

    public function __construct(GameConfig $gameConfig)
    {
        $this->gameConfig = $gameConfig;
    }

    /**
     * @return int
     */
    public function getIterations(): int
    {
        return $this->iterations;
    }

    public function getFirst(): GameState
    {
        $this->seenStatesHashes[] = md5(json_encode($this->queue[0]));

        return $this->queue[0];
    }

    public function add(GameState $item) {
        $this->seenStatesHashes[] = md5(json_encode($item->getCurrent()));

        $this->iterations ++;


        if(self::isSolution($item)) {
            $this->queue = [];
            $this->winner = $item;

            return;
        }


        $this->queue[] = $item;
    }

    public function removeFirst()
    {
        array_shift($this->queue);
    }

    public function isEmpty()
    {
        return count($this->queue) === 0;
    }

    public function isNotSeen(array $state)
    {
        return array_search(md5(json_encode($state)), $this->seenStatesHashes) === false;
    }

    private function isSolution(GameState $gameState)
    {
        $state = $gameState->getCurrent();

        if($this->gameConfig->isSolution($state)) {
            return true;
        }

        return false;
    }
}
