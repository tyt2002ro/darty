<?php

namespace App;

use \App\Exceptions\GameThrowInvalidException;

class GameThrowValidator
{
    protected $singlePoints;

    public function __construct()
    {
        $this->singlePoints = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
    }

    public function validatePoints(int $points): bool
    {
        if (in_array($points, $this->getAllAvailablePoints())) {
            return true;
        }

        throw new GameThrowInvalidException();
    }

    private function getAllAvailablePoints(): array
    {
        $availablePoints = array_merge($this->getSinglePoints(), $this->getDoublePoints());
        $availablePoints = array_merge($availablePoints, $this->getTriplePoints());
        $availablePoints = array_merge($availablePoints, $this->getBullseyePoints());

        return array_unique($availablePoints);
    }

    private function getSinglePoints(): array
    {
        return $this->singlePoints;
    }

    private function getDoublePoints(): array
    {
        return array_map(function ($point) {
            return $point * 2;
        }, $this->singlePoints);
    }

    private function getTriplePoints(): array
    {
        return array_map(function ($point) {
            return $point * 3;
        }, $this->singlePoints);
    }

    private function getBullseyePoints(): array
    {
        $outerBullseye = 25;
        $innerBullseye = 50;

        return [$outerBullseye, $innerBullseye];
    }
}