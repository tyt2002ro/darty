<?php

namespace App\Service;

use App\Entity\Player;
use App\Exceptions\PlayerNotExistException;

class EditPlayerService
{

    /**
     * @throws PlayerNotExistException
     */
    public function getPlayerFromDb($managerRegistry, $playerId): Player
    {
        $player = $managerRegistry->getRepository(Player::class)->find($playerId);
        if ($player !== null) {
            return $player;
        } else {
            throw new PlayerNotExistException("This player does not exist");
        }
    }

    public function editAnExistentPlayer($form, $request, $managerRegistry): void
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($player);
            $entityManager->flush();
        }
    }
}