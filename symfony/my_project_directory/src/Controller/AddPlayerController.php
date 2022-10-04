<?php

namespace App\Controller;

use App\Entity\Player;
use App\Factory\PlayerFactory;
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

        $player = [
            'firstname' => '',
            'lastname' => '',
            'nickname' => ''
        ];

        return $this->render('darty/addPlayer.html.twig', [
            'player' => $player
        ]);
    }

    #[Route('/buildPlayer', name: 'buildPlayerAction', methods: ['post'])]
    public function buildPlayerAction(PersistenceManagerRegistry $doctrine, Request $request): RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $playerFactory = new PlayerFactory();

        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $nickname = $request->get('nickname');
        $player = $playerFactory->createPlayer($firstname,$lastname,$nickname);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirect('/', 301);
    }

}
