<?php

namespace App\Service;

use App\Entity\Player;
use App\Exceptions\PlayerNotExistException;
use Doctrine\Persistence\ManagerRegistry;

class EditPlayerService
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;

    }

    /**
     * @throws PlayerNotExistException
     */
    public function getPlayerFromDb($playerId): Player
    {
        $player = $this->managerRegistry->getRepository(Player::class)->find($playerId);
        if ($player === null) {
            throw new PlayerNotExistException("This player does not exist");
        }
        return $player;
    }

    public function editAnExistentPlayer($form, $request): void
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($player);
            $entityManager->flush();
        }
    }
}