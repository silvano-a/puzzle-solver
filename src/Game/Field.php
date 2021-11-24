<?php

namespace app\Game;

final class Field
{
    public static function getField(): array
    {
        return
            [
                ['w', 'w', 'a', 'w', 'w'],
                ['c', '.', '.', '.', 'f'],
                ['w', 'w', 'e', 'w', 'w'],
            ];
    }

    public static function getGrid(): array
    {
        return [
            'y' => 3,
            'x'=> 5
        ];
    }

    private static function getCars()
    {
        return ['a','c','d','e','f','g'];
    }

    private static function addMove(Queue $queue, GameState $gameState, string $car, string $mode, array $currentLocation) {

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


    public static function calculateNextMoves(Queue $queue)
    {
        $objectItem = $queue->getFirst();
        $item = $objectItem->getCurrent();

        foreach($item as $rowNumber => $row) {
            foreach(self::getCars() as $car) {
                if(array_search($car, $row) !== false) {
                    $location = array_search($car, $row);

                    if(self::notOutOfBoundsX($location +1)) {
                        self::addMove($queue, $objectItem, $car, 'MOVE_RIGHT', [$rowNumber, $location]);
                    }

                    if(self::notOutOfBoundsX($location -1)) {
                        self::addMove($queue, $objectItem, $car, 'MOVE_LEFT', [$rowNumber, $location]);
                    }

                    if(self::notOutOfBoundsY($rowNumber +1)) {
                        self::addMove($queue, $objectItem, $car, 'MOVE_DOWN', [$rowNumber, $location]);
                    }

                    if(self::notOutOfBoundsY($rowNumber -1)) {
                        self::addMove($queue, $objectItem, $car, 'MOVE_UP', [$rowNumber,$location]);
                    }
                }
            }
        }

        $queue->removeFirst();

        return [];
    }

    private static function notOutOfBoundsx($number) {
        if($number < 0 ) {
            return false;
        }

        return $number < self::getGrid()['x'];
    }

    private static function notOutOfBoundsY($number) {
        if($number < 0 ) {
            return false;
        }
        return $number < self::getGrid()['y'];
    }

}
