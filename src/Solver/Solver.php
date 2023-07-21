<?php

namespace app\Solver;

use app\Game\GameConfig;
use app\Game\GameState;

final class Solver
{
    /**
     * @var GameConfig
     */
    private $gameConfig;

    private $iterations = 0;

    public function solve(GameConfig $gameConfig): ?GameState
    {
        $this->gameConfig = $gameConfig;

        // initialize first gamestate to start solving from.
        $initGameState = new GameState();
        $initGameState->add($gameConfig->getField());

        return null;
    }

    public function getIterations(): int
    {
        return $this->iterations;
    }
}
