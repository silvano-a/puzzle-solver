<?php

namespace app\Game;

final class Field
{
    /**
     * @var array
     */
    private $field;

    /**
     * @var array
     */
    private $grid;

    /**
     * @param array $field
     */
    public function setField(array $field)
    {
        $this->field = $field;
        $this->grid = [
            'x' => count($field[0]),
            'y' => count($field),
        ];
    }

    /**
     * @return array
     */
    public function getField(): array
    {
        return $this->field;
    }

    /**
     * @return array
     */
    public function getGrid(): array
    {
        return $this->grid;
    }

    /**
     * @return Field
     */
    public static function create(): self
    {
        $field = new self();
        $field->setField(
            self::get10x10()
        );

        return $field;
    }

    private static function get10x10(): array
    {
        return [
            ['a', 'X', '.', 'X', 'X', 'X', '.', '.', '.', '.'],
            ['.', 'X', '.', 'X', '.', 'X', '.', 'X', 'X', '.'],
            ['.', '.', '.', 'X', '.', 'X', '.', 'X', '.', '.'],
            ['.', 'X', 'X', 'X', '.', 'X', '.', 'X', '.', 'X'],
            ['.', 'X', '.', '.', '.', 'X', '.', 'X', '.', '.'],
            ['.', '.', '.', 'X', '.', 'X', '.', 'X', 'X', '.', '🏁'],
            ['.', 'X', 'X', 'X', '.', 'X', '.', 'X', '.', 'X'],
            ['.', 'X', '.', 'X', '.', 'X', '.', 'X', '.', 'X'],
            ['.', 'X', '.', 'X', '.', 'X', '.', 'X', '.', 'X'],
            ['.', '.', '.', 'X', '.', '.', '.', '.', '.', 'X'],
        ];
    }
}
