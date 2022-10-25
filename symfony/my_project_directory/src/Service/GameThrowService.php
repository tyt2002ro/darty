<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Factory\GameThrowFactory;
use App\Repository\GameThrowRepository;

class GameThrowService
{
    public function __construct(private readonly GameThrowFactory $gameThrowFactory, private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    public function addGameThrow(int $points, bool $double, bool $triple, Player $player, Game $game): GameThrow
    {
        $gameThrow = $this->gameThrowFactory->createFromValues($points, $double, $triple, $player, $game);

        $this->gameThrowRepository->save($gameThrow, true);
        return $gameThrow;
    }
}