<?php

namespace App\Controller;

final class DoubleOutSuggestionClass
{
    private $singleNumbers = [1, 18, 4, 13, 6, 10, 15, 2, 17, 3, 19, 7, 16, 8, 11, 14, 9, 12, 5, 20, 25, 50];
    private $doubleNumbers = [2, 36, 8, 26, 12, 20, 30, 4, 34, 6, 38, 14, 32, 16, 22, 28, 18, 24, 10, 40];
    private $tripleNumbers = [3, 52, 12, 39, 18, 30, 45, 6, 54, 9, 57, 21, 48, 24, 33, 42, 27, 36, 15, 60];
    private $suggestionResult = [];

    /* arr[] ---> Input Array
    data[] ---> Temporary array to
                store current combination
    start & end ---> Starting and Ending
                     indexes in arr[]
    index ---> Current index in data[]
    r ---> Size of a combination
           to be printed */
    function combinationUtil($arr, $data,
                             $end, $index, $int)

    {
        // Current combination is ready
        // to be printed, print it
        if ($index == 3)
        {
            if(in_array($data[2], $this->doubleNumbers)){
                $array = [];
                for ($j = 0; $j < 3; $j++) {
                    $array[] = $data[$j];
                }
                if (!in_array($array, $this->suggestionResult)){
                    if(array_sum($array) == $int)
                    $this->suggestionResult[] = $array;
                }
            }

            return;
        }

        // replace index with all
        // possible elements. The
        // condition "end-i+1 >=
        // r-index" makes sure that
        // including one element at
        // index will make a combination
        // with remaining elements at
        // remaining positions
        for ($i = 0;
             $i <= $end &&
             $end - $i + 1 >= 3 - $index; $i++)
        {
            $data[$index] = $arr[$i];
            $this->combinationUtil($arr, $data, $i + 1,
                $end, $index + 1, $int);
        }


        return$this->suggestionResult;
    }


    public function returnEndOptions(int $int): array
    {
        $numberOfCombinations = 3;
        $numberOfAvailablePointsOnTable = count(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers));
//        $trei = $this->printCombination(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers),
//            $numberOfAvailablePointsOnTable, $numberOfCombinations);
        $trei = $this->combinationUtil(array_merge($this->singleNumbers, $this->doubleNumbers, $this->tripleNumbers), [],
            $numberOfAvailablePointsOnTable - 1, 0, $numberOfCombinations, $int);
        return $trei;
    }

}