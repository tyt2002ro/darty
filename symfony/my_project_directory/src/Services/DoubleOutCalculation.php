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
    public const DOUBLE_NUMBER = "D";
    public const TRIPLE_NUMBER = "T";
    public DoubleOutSuggestion $suggestionResult;

    public function __construct()
    {
        //single numbers: 1->20 + single bull (25) and double bull (50)
        $this->singleNumbers = range(1, 20);

        //duplicate single numbers
        $this->doubleNumbers = array_map(static function ($item): float|int {
            return $item * 2;
        }, $this->singleNumbers);

        //triples single numbers and remove triple of single bull (there is no triple bull)
        $this->tripleNumbers = array_diff(array_map(static function ($item): float|int {
            return $item * 3;
        }, $this->singleNumbers), [75]);

        $this->suggestionResult = new DoubleOutSuggestion();
    }

    public function returnEndOptions(int $points): string
    {
        $combinations = 3;
        $numberOfAvailablePointsOnTable = count(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers));
        $pointOptions = array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers);
        $endOption = $this->combinations($pointOptions, [], 0, $numberOfAvailablePointsOnTable - 1,
            0, $combinations, $points);
        return $this->formatReturn($endOption);
    }

    private function combinations(array $pointOptions, array $data, int $start, int $end, int $index, int $combinations, int $points): DoubleOutSuggestion
    {
        if ($index === $combinations) {
            $this->buildCombinationSuggestion($data, $points);
            return $this->suggestionResult;
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

            if ($this->suggestionResult->getDoubleOut() < $data[2] && array_sum($data) === $points) {
                $this->suggestionResult->setFirstNumber($data[0]);
                $this->suggestionResult->setSecondNumber($data[1]);
                $this->suggestionResult->setDoubleOut($data[2]);
            }
        }
    }

    private function formatReturn(DoubleOutSuggestion $endOption): string
    {
        $option = '';
        $firstNumber = $endOption->getFirstNumber();
        if (in_array($firstNumber, $this->doubleNumbers, true)) {
            $option .= self::DOUBLE_NUMBER . $firstNumber / 2;
        } elseif (in_array($firstNumber, $this->tripleNumbers, true)) {
            $option .= self::TRIPLE_NUMBER . $firstNumber / 3;
        } else {
            $option .= $firstNumber;
        }
        $option .= ", ";

        $secondNumber = $endOption->getSecondNumber();
        if (in_array($secondNumber, $this->doubleNumbers, true)) {
            $option .= self::DOUBLE_NUMBER . $secondNumber / 2;
        } elseif (in_array($secondNumber, $this->tripleNumbers, true)) {
            $option .= self::TRIPLE_NUMBER . $secondNumber / 3;
        } else {
            $option .= $secondNumber;
        }
        $option .= ", ";

        $doubleOut = $endOption->getDoubleOut();
        $option .= self::DOUBLE_NUMBER . $doubleOut / 2;

        return $option;
    }

    public function returnValueOfFormattedOption($option): float|int|string
    {
        $optionNumbers = explode(",", $option);
        $sum = 0;
        foreach ($optionNumbers as $number) {
            if (str_starts_with(trim($number), self::DOUBLE_NUMBER)) {
                $sum += (int)str_replace(self::DOUBLE_NUMBER, "", trim($number)) * 2;
            } elseif (str_starts_with(trim($number), self::TRIPLE_NUMBER)) {
                $sum += (int)str_replace(self::TRIPLE_NUMBER, "", trim($number)) * 3;
            } else {
                $sum += (int)$number;
            }
        }
        return $sum;
    }

    public function calculate(int $score): \App\DataObjects\DoubleOutSuggestion
    {

        rsort($this->tripleNumbers);
        rsort($this->doubleNumbers);

        $firstThrow = '';
        $secondThrow = '';
        $thirdThrow = '';

        foreach ($this->doubleNumbers as $doubleNumber) {
            if ($score - $doubleNumber >= 0) {
                $thirdThrow = self::DOUBLE_NUMBER . $doubleNumber / 2;
                $score -= $doubleNumber;
                break;
            }
        }

        $allowedNumbers = array_unique(array_merge($this->tripleNumbers, $this->doubleNumbers, $this->singleNumbers));
        rsort($allowedNumbers);
        if ($score > 0) {
            $modifier = '';
            $divider = 1;
            foreach ($allowedNumbers as $number) {
                if ($score - $number >= 0) {
                    if (in_array($number, $this->tripleNumbers, true)) {
                        $modifier = self::TRIPLE_NUMBER;
                        $divider = 3;
                    }
                    if (in_array($number, $this->doubleNumbers, true)) {
                        $modifier = self::DOUBLE_NUMBER;
                        $divider = 2;
                    }
                    $firstThrow = $modifier . $number / $divider;
                    $score -= $number;
                    break;
                }
            }
        }
        if ($score > 0) {
            $modifier = '';
            $divider = 1;
            foreach ($allowedNumbers as $number) {
                if ($score - $number >= 0) {
                    if (in_array($number, $this->tripleNumbers, true)) {
                        $modifier = self::TRIPLE_NUMBER;
                        $divider = 3;
                    }
                    if (in_array($number, $this->doubleNumbers, true)) {
                        $modifier = self::DOUBLE_NUMBER;
                        $divider = 2;
                    }
                    $secondThrow = $modifier . $number / $divider;
                    $score -= $number;
                    break;
                }
            }
        }

        return new \App\DataObjects\DoubleOutSuggestion($firstThrow, $secondThrow, $thirdThrow);
    }
}
