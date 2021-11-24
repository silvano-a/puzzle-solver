<?php
namespace app\Game;

final class GameConfig
{
    /**
     * @var Field
     */
    private $field;

    public function __construct()
    {
        $this->field = Field::create();
    }

    /**
     * @return field
     */
    public function getField(): array
    {
        return $this->field->getField();
    }

    public function getCars(): array
    {
        return ['a','c','d','e','f','g'];
    }

    public function notOutOfBoundsx($number) {
        if($number < 0 ) {
            return false;
        }

        return $number < $this->field->getGrid()['x'];
    }

    public function notOutOfBoundsY($number) {
        if($number < 0 ) {
            return false;
        }
        return $number < $this->field->getGrid()['y'];
    }

    public function isSolution(array $field)
    {
        if($field[5][9] == 'a')
        {
            return true;
        }

        return false;
    }
}
