<?php

namespace App\Service;

use App\Repository\PlayerRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePlayerService
{
    protected PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function deleteById(int $id): void
    {
        $player = $this->playerRepository->findOneById($id);
        if (empty($player)) {
            throw new NotFoundHttpException('No player found for id ' . $id, null);
        }

        $this->playerRepository->remove($player, true);
    }
}

