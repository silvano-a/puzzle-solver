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

    public function notOutOfBoundsx($number): bool {
        if($number < 0 ) {
            return false;
        }

        return $number < $this->field->getGrid()['x'];
    }

    public function notOutOfBoundsY($number): bool {
        if($number < 0 ) {
            return false;
        }
        return $number < $this->field->getGrid()['y'];
    }

    public function isSolution(array $field): bool
    {
        if($field[1][9] == 'a')
        {
            return true;
        }

        return false;
    }

    public function getSolutionAsString(): string
    {
        return 'y=0, x=9';
    }
}
