<?php

namespace App\Services;

class DoubleOutSuggestion
{
    private int $firstNumber;
    private int $secondNumber;
    private int $doubleOut;

    public function setFirstNumber(string $firstNumber): self
    {
        $this->firstNumber = $firstNumber;
        return $this;
    }

    public function setSecondNumber(string $secondNumber): self
    {
        $this->secondNumber = $secondNumber;
        return $this;
    }

    public function setDoubleOut(string $doubleOut): self
    {
        $this->doubleOut = $doubleOut;
        return $this;
    }
}
