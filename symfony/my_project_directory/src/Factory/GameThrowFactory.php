<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
//use App\Factory\Player;

class GameThrowFactory
{
    public function createFromValues(int $points, bool $double, bool $triple, Player $player, Game $game): GameThrow
    {
        if($double === true) {
            $points *= 2;
        } elseif ($triple === true) {
            $points *=3;
        }

        $gameThrow = new GameThrow();
        $gameThrow->setPlayer(player: $player);
        $gameThrow->setGame(game: $game);
        $gameThrow->setPoints($points);
        $gameThrow->setThrowOrder(1);

        return $gameThrow;
    }
}
