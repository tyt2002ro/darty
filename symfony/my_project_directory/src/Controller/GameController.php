<?php

namespace App\Controller;

use App\Entity\Game;
use App\Service\GameService;
use App\Service\NextPlayerToThrowService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private readonly NextPlayerToThrowService $nextPlayerToThrowService,
                                private readonly GameService $gameService)
    {
    }

    #[Route('/createGame', name: 'create_game')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $type = $request->request->get('games');
        $endOptions = $request->request->get('gameEnds');
        $playerIds = $request->request->all()['player'];

        $gameId = $this->gameService->createGame($type, $playerIds, $endOptions);

        return $this->redirect('/game/' . $gameId, 301);
    }

    #[Route('/game/{id}', name: 'app_game')]
    public function index(Game $game): Response
    {
        $players = $game->getSortedById();

        $playersData = [];
        $mainPlayerData = $this->nextPlayerToThrowService
            ->returnNextPlayerToThrow($game->getId(), $players, $playersData);

        $otherPlayersData = $this->nextPlayerToThrowService
            ->returnOtherPlayerData($playersData, $mainPlayerData['order']);

        return $this->render('game/index.html.twig', [
            'player_id' => $mainPlayerData['player_id'],
            'mainPlayerData' => $mainPlayerData,
            'otherPlayersData' => $otherPlayersData,
            'game_id' => $game->getId(),
            'controller_name' => 'GameController'
        ]);
    }

}
