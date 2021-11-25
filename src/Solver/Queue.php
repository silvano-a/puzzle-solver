<?php

namespace app\Solver;

use app\Game\GameConfig;
use app\Game\GameState;

final class Queue
{
    /**
     * @var array
     */
    private $queue;

    /**
     * @var array
     */
    private $seenStatesHashes = [];

    /**
     * @var null|GameState
     */
    public $winner = null;

    /**
     * @var int
     */
    private $iterations = 0;

    /**
     * @var GameConfig
     */
    private $gameConfig;

    public function __construct(GameConfig $gameConfig)
    {
        $this->gameConfig = $gameConfig;
    }

    public function initialize(GameState $gameState) {
        $this->queue[0] = $gameState;
    }


    public function getIterations(): int
    {
        return $this->iterations;
    }

    public function getFirst(): GameState
    {
        $this->seenStatesHashes[] = md5(json_encode($this->queue[0]));

        return $this->queue[0];
    }

    public function add(GameState $item): void {
        $this->seenStatesHashes[] = md5(json_encode($item->getCurrent()));

        $this->iterations ++;

        if(self::isSolution($item)) {
            $this->queue = [];
            $this->winner = $item;

            return;
        }

        $this->queue[] = $item;
    }

    public function removeFirst(): void
    {
        array_shift($this->queue);
    }

    public function isEmpty(): bool
    {
        return count($this->queue) === 0;
    }

    public function isNotSeen(array $state): bool
    {
        return array_search(md5(json_encode($state)), $this->seenStatesHashes) === false;
    }

    private function isSolution(GameState $gameState): bool
    {
        $state = $gameState->getCurrent();

        if($this->gameConfig->isSolution($state)) {
            return true;
        }

        return false;
    }
}
