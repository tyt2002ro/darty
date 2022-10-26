<?php

namespace App\Validator;

use App\Exceptions\GameThrowInvalidException;

class GameThrowValidator
{
    protected array $singlePoints;

    public function __construct()
    {
        $this->singlePoints = array_merge(range(1, 20), [25]);
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
        $availablePoints = array_merge($this->getSinglePoints(), $this->getDoublePoints(), $this->getTriplePoints());

        return array_unique($availablePoints);
    }

    private function getSinglePoints(): array
    {
        return $this->singlePoints;
    }

    private function getDoublePoints(): array
    {
        return array_map(static function ($item): float|int {
            return $item * 2;
        }, $this->singlePoints);
    }

    private function getTriplePoints(): array
    {
        return array_diff(array_map(static function ($item): float|int {
            return $item * 3;
        }, $this->singlePoints), [75]);
    }
}