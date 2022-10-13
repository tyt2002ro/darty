<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameThrowController extends AbstractController
{
    #[Route('/game/throw', name: 'app_game_throw')]
    public function index(): Response
    {
        return $this->render('game_throw/index.html.twig', [
            'controller_name' => 'GameThrowController',
        ]);
    }

    #[Route('create/game_throw/game/{{game_id}}/player/{{ main_player_id }}/value/{id}', name: 'app_game_throw')]
    public function index(): Response
    {
        return $this->render('game_throw/index.html.twig', [
            'controller_name' => 'GameThrowController',
        ]);
    }


}
