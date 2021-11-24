<?php

namespace app\Game;

final class Queue
{
    private $queue;

    private $seenStatesHashes = [];

    public $winner = null;

    private $iterations = -1;

    public function print(array $field)
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';   //^[H^[J
        echo '-------------------' . PHP_EOL;

        foreach($field as $row )
        {
            foreach($row as $column) {
                echo $column. ' ';
            }

            echo PHP_EOL;
        }
        echo '-------------------' . PHP_EOL;

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

        if($state[1][0] === 'f' && $state[1][4] === 'c' && $state[2][2] === 'a' && $state[0][2] === 'e') {
            return true;
        }

        return false;
    }
}
