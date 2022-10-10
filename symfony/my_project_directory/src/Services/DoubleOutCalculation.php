<?php

namespace App\Services;

class DoubleOutCalculation
{
    /**
     * @var array
     */
    private array $singleNumbers;
    private array $doubleNumbers;
    private array $tripleNumbers;
    private array $suggestionResult = [];

    public function __construct()
    {
        //single numbers: 1->20 + single bull (25) and double bull (50)
        $this->singleNumbers = array_merge(range(1, 20), [20, 25]);

        //duplicate single numbers
        $this->doubleNumbers = array_map(static function ($item): float|int {
            return $item * 2;
        }, $this->singleNumbers);

        //triples single numbers and remove triple of single bull (there is no triple bull)
        $this->tripleNumbers = array_diff(array_map(static function ($item): float|int {
            return $item * 3;
        }, $this->singleNumbers), [75]);

    }

    public function returnEndOptions(int $points): array
    {
        $combinations = 3;
        $numberOfAvailablePointsOnTable = count(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers));
        $pointOptions = array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers);
        return $this->combinations($pointOptions, [], 0, $numberOfAvailablePointsOnTable - 1,
            0, $combinations, $points);
    }

    private function combinations(array $pointOptions, array $data, int $start, int $end, int $index, int $combinations, int $points): array
    {
        if ($index === $combinations) {
            $this->buildCombinationSuggestion($data, $points);
            return [];
        }

        for ($i = $start; $i <= $end && $end - $i + 1 >= $combinations - $index; $i++) {
            $data[$index] = $pointOptions[$i];
            $this->combinations($pointOptions, $data, $i + 1, $end, $index + 1, $combinations, $points);
        }
        return $this->suggestionResult;
    }

    private function buildCombinationSuggestion(array $data, int $points): void
    {
            if (in_array($data[2], $this->doubleNumbers, true)) {
                $array = '';
                $sum = [];
                for ($j = 0; $j < 3; $j++) {
                    $array .= $data[$j] . ', ';
                    $sum[] = $data[$j];
                }
                if (!in_array($array, $this->suggestionResult, true)) {
                    if (array_sum($sum) === $points) $this->suggestionResult[] = $array;
                }
            }
    }
}
