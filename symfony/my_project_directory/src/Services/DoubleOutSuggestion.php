<?php

namespace App\Services;

class DoubleOutSuggestion
{
    private int $firstNumber;
    private int $secondNumber;
    private int $doubleOut;

    public function __construct()
    {
        $this->setFirstNumber(0);
        $this->setSecondNumber(0);
        $this->setDoubleOut(0);
    }
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

    /**
     * @return int
     */
    public function getFirstNumber(): int
    {
        return $this->firstNumber;
    }

    /**
     * @return int
     */
    public function getSecondNumber(): int
    {
        return $this->secondNumber;
    }

    /**
     * @return int
     */
    public function getDoubleOut(): int
    {
        return $this->doubleOut;
    }

    public function setDoubleOutFormat(): int
    {}
}
