<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Service\NextPlayerToThrowService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    private NextPlayerToThrowService $nextPlayerToThrowService;

    public function __construct(NextPlayerToThrowService $nextPlayerToThrowService)
    {
        $this->nextPlayerToThrowService = $nextPlayerToThrowService;
    }

    #[Route('/createGame', name: 'create_game')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $game = new Game();
        $game->setType($request->request->get('games'));
        $game->setGameOption($request->request->get('gameEnds'));

        $playerIds = $request->request->all()['player'];
        foreach($playerIds as $playerId)
        {
            $player = $doctrine->getRepository(Player::class)->findOneBy(array('id' => $playerId));
            $game->addPlayerId($player);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($game);
        $entityManager->flush();

        return $this->redirect('/game/'.$game->getId(), 301);
    }

    #[Route('/game/{id}', name: 'app_game')]
    public function index(Request $request, ManagerRegistry $doctrine, Game $game): Response
    {
        $players = $game->getSortedById();

        $playersData = [];
        $mainPlayerData = $this->nextPlayerToThrowService->returnNextPlayerToThrow($game->getId(),$players, $playersData);

        return $this->render('game/index.html.twig', [
            'player_id' => $mainPlayerData['player_id'],
            'mainPlayerData' => $mainPlayerData,
            'game_id' => $game->getId(),
            'controller_name' => 'GameController'
        ]);
    }

}
