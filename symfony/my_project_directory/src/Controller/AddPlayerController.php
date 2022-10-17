<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class AddPlayerController extends AbstractController
{

    #[Route('/addPlayerForm', name: 'addPlayerForm', methods: ['GET'])]
    public function addPlayerFormAction(): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);

        return $this->renderForm('darty/addPlayer.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addPlayerForm', name: 'buildPlayerAction', methods: ['post'])]
    public function buildPlayerAction(PersistenceManagerRegistry $doctrine, Request $request): RedirectResponse
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($player);
            $entityManager->flush();
        }

        return $this->redirect('/', 301);
    }
}
