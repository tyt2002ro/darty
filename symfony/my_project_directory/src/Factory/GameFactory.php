<?php

namespace App\Factory;

use App\Entity\Game;
use App\Exceptions\PlayerNotExistException;
use App\Repository\PlayerRepository;
use App\Service\SortPlayersThrowOrderService;

class GameFactory
{

    public function __construct(private readonly PlayerRepository $playerRepository)
    {
    }

    /**
     * @throws PlayerNotExistException
     */
    public function createGame(int $type, array $playerIds, string $endOptions, array $order): Game
    {
        $game = new Game();
        $game->setType($type);
        $game->setGameOption($endOptions);

        $game->setThrowPlayersOrder($order);

        foreach ($playerIds as $playerId) {
            $player = $this->playerRepository->find($playerId);
            if($player === null)
            {
                throw new PlayerNotExistException('player not exist with id: ' . $playerId);
            }

            $game->addPlayerId($player);
        }

        return $game;
    }
}
