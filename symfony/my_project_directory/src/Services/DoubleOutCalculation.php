<?php

class DoubleOutCalculation
{
    private array $singleNumbers = [1, 18, 4, 13, 6, 10, 15, 2, 17, 3, 19, 7, 16, 8, 11, 14, 9, 12, 5, 20, 25, 50];
    private array $doubleNumbers = [2, 36, 8, 26, 12, 20, 30, 4, 34, 6, 38, 14, 32, 16, 22, 28, 18, 24, 10, 40];
    private array $tripleNumbers = [3, 52, 12, 39, 18, 30, 45, 6, 54, 9, 57, 21, 48, 24, 33, 42, 27, 36, 15, 60];
    private array $suggestionResult = [];

    private function combinations($arr, $data, $start, $end, $index, $combinations, $points): array
    {
        if ($index == $combinations) {
            if (in_array($data[2], $this->doubleNumbers)) {
                $array = '';
                $sum = [];
                for ($j = 0; $j < 3; $j++) {
                    $array .= $data[$j] . ', ';
                    $sum[] = $data[$j];
                }
                if (!in_array($array, $this->suggestionResult, true)) {
                    if (array_sum($sum) == $points)
                        $this->suggestionResult[] = $array;
                }
            }
            return [];
        }

        for ($i = $start; $i <= $end && $end - $i + 1 >= $combinations - $index; $i++) {
            $data[$index] = $arr[$i];
            $this->combinations($arr, $data, $i + 1, $end, $index + 1, $combinations, $points);
        }
        return $this->suggestionResult;
    }

    public function returnEndOptions(int $points): array
    {
        $combinations = 3;
        $numberOfAvailablePointsOnTable = count(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers));
        $pointOptions = array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers);
        return $this->combinations($pointOptions, [], 0, $numberOfAvailablePointsOnTable - 1, 0, $combinations, $points);
    }
}