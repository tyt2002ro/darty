<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\GameThrow;

class GameThrowFactory
{
    public function createFromValues(int $points, bool $double, bool $triple, int $playerId, int $gameId): GameThrow
    {
        $gameThrow = new GameThrow();
        $gameThrow->setPlayerId($playerId);
        //...

        return $gameThrow;
    }
}
