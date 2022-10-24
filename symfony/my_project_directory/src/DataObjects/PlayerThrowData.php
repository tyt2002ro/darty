<?php
declare(strict_types=1);

namespace App\DataObjects;

final class PlayerThrowData
{

    public function __construct(private readonly int $player_id,
                                private readonly int $order,
                                private readonly string $name,
                                private readonly int $pointsTotal,
                                private readonly float $pointsAverage,
                                private readonly int $legThrows,
                                private readonly int $totalThrows,
    )
    {
    }

    public function getPlayerId(): int
    {
        return $this->player_id;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPointsTotal(): int
    {
        return $this->pointsTotal;
    }

    public function getLegThrows(): int
    {
        return $this->legThrows;
    }

    public function getPointsAverage(): float
    {
        return $this->pointsAverage;
    }

    public function getTotalThrows(): int
    {
        return $this->totalThrows;
    }
}
