<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function buildPlayerAction() : Response
    {

        return $this->redirect('/', 301);
        die(print_r($_POST));
//        print_r($_POST);
        $theree = 3;
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

        return $this->redirect('/', 301);
    }

}