<?php

namespace App\Service;

use App\Entity\Game;
use App\Factory\GameFactory;
use App\Repository\GameRepository;

class GameService
{

    public function __construct(private readonly GameRepository $gameRepository,
                                private readonly GameFactory    $gameFactory)
    {
    }

    public function createGame($type, $playerIds, $endOptions): Game
    {
        $game = $this->gameFactory->createGame($type, $playerIds, $endOptions);
        $this->gameRepository->save($game, true);

        return $game;
    }

    public function getPlayerPlace(Game $game, int $playerId): int
    {
        $playersPlace = $game->getPlayersPlace();
        $place = max($playersPlace) + 1;
        $playersPlace[$playerId] = $place;
        $game->setPlayersPlace($playersPlace);

        $this->gameRepository->save($game,true);

        return $place;
    }

    public function getCongratsMessage(int $playerPlace): string
    {
        $message = match ($playerPlace) {
            1 => "You won!",
            2 => "Congrats! You reached 2nd place",
            3 => "Congrats! You reached 3rd place",
            default => "Congrats! You reached " . $playerPlace . "th place",
        };
        return $message;
    }

}