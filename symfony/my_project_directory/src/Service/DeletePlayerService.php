<?php

namespace App\Service;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePlayerService
{
    protected PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function delete(Player|null $player): void
    {
        if ($player === null) {
            throw new NotFoundHttpException('No player found.', null);
        }

        $this->playerRepository->remove($player, true);
    }
}

