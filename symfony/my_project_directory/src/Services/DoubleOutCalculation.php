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
    public const D = "D";
    public const T = "T";
    public DoubleOutSuggestion $suggestionResult;

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

        $this->suggestionResult = new DoubleOutSuggestion();
    }

    public function returnEndOptions(int $points): string
    {
        $combinations = 3;
        $numberOfAvailablePointsOnTable = count(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers));
        $pointOptions = array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers);
        $endOption =  $this->combinations($pointOptions, [], 0, $numberOfAvailablePointsOnTable - 1,
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

                if($this->suggestionResult->getDoubleOut() < $data[2] && array_sum($data) === $points){
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
        if(in_array($firstNumber, $this->doubleNumbers, true)){
            $option .= self::D.$firstNumber/2;
        } elseif(in_array($firstNumber, $this->tripleNumbers, true)){
            $option .= self::T.$firstNumber/3;
        }else{
            $option .= $firstNumber;
        }
        $option .= ", ";

        $secondNumber = $endOption->getSecondNumber();
        if(in_array($secondNumber, $this->doubleNumbers, true)){
            $option .= self::D.$secondNumber/2;
        } elseif(in_array($secondNumber, $this->tripleNumbers, true)){
            $option .= self::T.$secondNumber/3;
        } else {
            $option .= $secondNumber;
        }
        $option .= ", ";

        $doubleOut = $endOption->getDoubleOut();
        $option .= self::D.$doubleOut/2;

        return $option;
    }

    public function returnValueOfFormattedOption($option): float|int|string
    {
        $optionNumbers = explode(",", $option);
        $sum = 0;
        foreach ($optionNumbers as $number){
            if(str_starts_with(trim($number), self::D)){
                $sum += (int)str_replace(self::D,"",trim($number))*2;
            } elseif(str_starts_with(trim($number), self::T)){
                $sum += (int)str_replace(self::T,"",trim($number))*3;
            } else {
                $sum += (int)$number;
            }
        }
        return $sum;
    }
}
