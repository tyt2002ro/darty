<?php
declare(strict_types=1);

namespace App\DataObjects;

final class DoubleOutSuggestion
{

    public function __construct(private readonly string $firstThrow,
                                private readonly string $secondThrow,
                                private readonly string $thirdThrow)
    {
    }

    public function getFirstThrow(): string
    {
        return $this->firstThrow;
    }

    public function getSecondThrow(): string
    {
        return $this->secondThrow;
    }

    public function getThirdThrow(): string
    {
        return $this->thirdThrow;
    }
}
