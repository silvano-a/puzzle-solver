<?php

namespace app\Solver;

use app\Game\GameConfig;
use app\Game\GameState;

final class Solver
{
    /**
     * @var Queue
     */
    private $queue;

    /**
     * @var GameConfig
     */
    private $gameConfig;

    public function solve(GameConfig $gameConfig): ?GameState
    {
        $this->gameConfig = $gameConfig;
        $this->queue = new Queue($gameConfig);

        // initialize first gamestate to start solving from.
        $initGameState = new GameState();
        $initGameState->add($gameConfig->getField());

        // Add the first gamestate to the queue
        $this->queue->initialize($initGameState);

        return $this->searchBreadthFirst();
    }

    private function searchBreadthFirst(): ?GameState
    {
        while($this->queue->isEmpty() === false) {
            $this->calculateNextMoves();
        }

        return $this->queue->winner;
    }


    private function calculateNextMoves()
    {
        $queue = $this->queue;

        // get the next item from the queue
        $gameState = $queue->getFirst();
        $item = $gameState->getCurrent();

        foreach($item as $rowNumber => $row) {
            foreach($this->gameConfig->getCars() as $car) {
                if(array_search($car, $row) !== false) {
                    $location = array_search($car, $row);

                    if($this->gameConfig->notOutOfBoundsX($location +1)) {
                        $this->addMove($queue, $gameState, $car, 'MOVE_RIGHT', [$rowNumber, $location]);
                    }

                    if($this->gameConfig->notOutOfBoundsX($location -1)) {
                        $this->addMove($queue, $gameState, $car, 'MOVE_LEFT', [$rowNumber, $location]);
                    }

                    if($this->gameConfig->notOutOfBoundsY($rowNumber +1)) {
                        $this->addMove($queue, $gameState, $car, 'MOVE_DOWN', [$rowNumber, $location]);
                    }

                    if($this->gameConfig->notOutOfBoundsY($rowNumber -1)) {
                        $this->addMove($queue, $gameState, $car, 'MOVE_UP', [$rowNumber,$location]);
                    }
                }
            }
        }

        $queue->removeFirst();

        return [];
    }

    private function addMove(Queue $queue, GameState $gameState, string $car, string $mode, array $currentLocation) {


        $state = $gameState->getCurrent();

        if($mode === 'MOVE_RIGHT') {
            $newLocation = $currentLocation[1] +1;

            if($state[$currentLocation[0]][$newLocation] != '.') {
                return;
            }

            $state[$currentLocation[0]][$currentLocation[1]] = '.';
            $state[$currentLocation[0]][$newLocation] = $car;
        }

        if($mode === 'MOVE_LEFT') {
            $newLocation = $currentLocation[1] -1;

            if($state[$currentLocation[0]][$newLocation] != '.') {
                return;
            }

            $state[$currentLocation[0]][$currentLocation[1]] = '.';
            $state[$currentLocation[0]][$newLocation] = $car;
        }

        if($mode === 'MOVE_DOWN') {
            $newLocation = $currentLocation[0] +1;

            if($state[$newLocation][$currentLocation[1]] != '.') {
                return;
            }
            $state[$currentLocation[0]][$currentLocation[1]] = '.';
            $state[$newLocation][$currentLocation[1]] = $car;
        }

        if($mode === 'MOVE_UP') {
            $newLocation = $currentLocation[0] -1;

            if($state[$newLocation][$currentLocation[1]] != '.') {
                return;
            }
            $state[$currentLocation[0]][$currentLocation[1]] = '.';
            $state[$newLocation][$currentLocation[1]] = $car;
        }

        if($queue->isNotSeen($state)) {
            $newState = clone $gameState;

            $newState->add($state);
            $queue->add($newState);
        }
    }

    public function getIterations(): int
    {
        return $this->queue->getIterations();
    }
}
