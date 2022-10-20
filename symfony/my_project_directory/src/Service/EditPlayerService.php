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