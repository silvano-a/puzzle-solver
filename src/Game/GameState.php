<?php
namespace app\Game;

final class GameState
{
    private $history;

    private $current;

    public function add(array $item)
    {
        $this->current = $item;
        $this->history[] = $item;
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }
}
