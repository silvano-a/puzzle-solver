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
     * @return array
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @return array
     */
    public function getCurrent()
    {
        return $this->current;
    }

    public function animate()
    {
        foreach($this->history as $field) {
            $this->printField($field);
            usleep(200000);
        }

    }

    private function printField(array $field)
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
}
