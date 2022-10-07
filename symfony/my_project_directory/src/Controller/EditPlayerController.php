<?php

namespace App\Controller;

use App\Entity\Player;
use App\Exceptions\PlayerNotExistException;
use App\Form\PlayerType;
use App\Service\EditPlayerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditPlayerController extends AbstractController
{
    /**
     * @throws PlayerNotExistException
     */
    #[Route('/edit/player/{playerId}', name: 'app_edit_player', methods: ['GET'])]
    public function editPlayerFormAction(ManagerRegistry $managerRegistry, int $playerId): Response
    {
        $playerService = new EditPlayerService();
        $player = $playerService->getPlayerFromDb($managerRegistry,$playerId);
        $form = $this->createForm(PlayerType::class, $player);

        return $this->renderForm('darty/editPlayer.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws PlayerNotExistException
     */
    #[Route('/edit/player/{playerId}', name: 'editPlayerAction', methods: ['post'])]
    public function editPlayerAction(ManagerRegistry $managerRegistry, Request $request,$playerId): RedirectResponse
    {
        $editPlayerService =  new EditPlayerService();
        $player = $editPlayerService->getPlayerFromDb($managerRegistry, $playerId);

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($player);
            $entityManager->flush();
        }

        return $this->redirect('/player-management', 301);

    }
}
