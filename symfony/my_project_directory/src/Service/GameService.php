<?php

namespace App\Service;

use App\Entity\Game;
use App\Factory\GameFactory;
use App\Repository\GameRepository;

class GameService
{

    public function __construct(private readonly GameRepository $gameRepository,
                                private readonly  GameFactory $gameFactory)
    {
    }

    public function createGame($type, $playerIds, $endOptions): Game
    {
        $game = $this->gameFactory->createGame($type, $playerIds, $endOptions);
        $this->gameRepository->save($game, true);

        return $game;
    }

}