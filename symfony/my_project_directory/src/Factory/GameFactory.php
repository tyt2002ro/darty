<?php

namespace App\Factory;

use App\Entity\Game;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @property ManagerRegistry $registry
 */
class GameFactory
{

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function createGame(int $type, array $playerIds,  string $endOptions): Game
    {
        $game = new Game();
        $game->setType($type);
        $game->setGameOption($endOptions);

        foreach ($playerIds as $playerId) {
            $player = $this->registry->getRepository(Player::class)->findOneBy(array('id' => $playerId));
            $game->addPlayerId($player);
        }

        return $game;
    }

}