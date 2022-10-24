<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function buildPlayerAction(PlayerRepository $playerRepository, Request $request): RedirectResponse
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $playerRepository->save($player, true);
        }

        return $this->redirect('/', 301);
    }
}
