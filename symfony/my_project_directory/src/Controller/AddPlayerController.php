<?php

namespace App\Controller;

use App\Entity\Player;
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
    public function buildPlayerAction(PersistenceManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();

        $player = new Player();
        $player->setFirstname($_POST['firstname']);
        $player->setLastname($_POST['lastname']);
        $player->setNickname($_POST['nickname']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirect('/', 301);
    }

}