<?php

namespace App\Service;

use App\DataObjects\DoubleOutSuggestion;

class DoubleOutCalculationService
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
    }

    public function calculate(int $score): DoubleOutSuggestion
    {
        rsort($this->tripleNumbers);
        rsort($this->doubleNumbers);

        $allowedNumbers = array_unique(array_merge($this->tripleNumbers, $this->doubleNumbers, $this->singleNumbers));
        rsort($allowedNumbers);

        $thirdThrow = $this->setThirdTrowRecommendation($score);
        $firstThrow = $this->setTrowRecommendation($score, $allowedNumbers);
        $secondThrow = $this->setTrowRecommendation($score, $allowedNumbers);

        return new DoubleOutSuggestion($firstThrow, $secondThrow, $thirdThrow);
    }

    private function setThirdTrowRecommendation(&$score): string
    {
        foreach ($this->doubleNumbers as $doubleNumber) {
            if ($score - $doubleNumber >= 0) {
                $thirdThrow = self::DOUBLE_NUMBER . $doubleNumber / 2;
                $score -= $doubleNumber;
                return $thirdThrow;
            }
        }
        return '';
    }

    private function setTrowRecommendation(&$score, $allowedNumbers): string
    {
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
                    $throw = $modifier . $number / $divider;
                    $score -= $number;
                    return $throw;
                }
            }
        }
        return '';
    }

    public function getDoubleOutNumbers(): array
    {
        return $this->doubleNumbers;
    }
}
