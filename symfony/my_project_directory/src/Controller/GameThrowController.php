<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameThrowController extends AbstractController
{
    #[Route('/add/throw', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $gameThrow = new GameThrow();
        $playerId = $request->get('player_id');
        $gameId = $request->get('game_id');

        $player = $doctrine->getRepository(Player::class)->find($playerId);
        $game = $doctrine->getRepository(Game::class)->find($gameId);
        $gameThrow->setPlayerId($player);
        $gameThrow->setGameId($game);
        $gameThrow->setPoints($request->get('points'));
        $gameThrow->setThrowOrder(1);


        $entityManager->persist($gameThrow);
        $entityManager->flush();

        return $this->redirect('/game/'.$gameId, 301);

    }
}
