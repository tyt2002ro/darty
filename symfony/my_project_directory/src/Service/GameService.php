<?php

namespace App\Service;

use App\Factory\GameFactory;
use App\Repository\GameRepository;
use Doctrine\Persistence\ManagerRegistry;

class GameService
{

    public function __construct(private readonly GameRepository $gameRepository,
                                private readonly  GameFactory $gameFactory)
    {
    }

    public function createGame($type, $playerIds, $endOptions)
    {
        $game = $this->gameFactory->createGame($type, $playerIds, $endOptions);
        $this->gameRepository->save($game, true);
    }

}