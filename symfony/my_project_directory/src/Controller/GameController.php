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
                                private readonly GameService              $gameService)
    {
    }

    #[Route('/createGame', name: 'create_game')]
    public function create(Request $request): Response
    {
        $type = $request->request->get('games');
        $endOptions = $request->request->get('gameEnds');
        $playerIds = $request->request->all()['player'];
        $order = $request->request->all()['order'];

        $game = $this->gameService->createGame($type, $playerIds, $endOptions, $order);

        return $this->redirect('/game/' . $game->getId(), 301);
    }

    #[Route('/game/{id}', name: 'app_game')]
    public function index(Game $game): Response
    {
        $playersData = [];
        $mainPlayerData = $this->nextPlayerToThrowService
            ->returnNextPlayerToThrow($game, $playersData);

        $otherPlayersData = $this->nextPlayerToThrowService
            ->returnOtherPlayerData($playersData, $mainPlayerData->getOrder());

        return $this->render('darty/game.html.twig', [
            'player_id' => $mainPlayerData->getPlayerId(),
            'mainPlayerData' => $mainPlayerData,
            'otherPlayersData' => $otherPlayersData,
            'game_id' => $game->getId(),
            'gameType' => $game->getType(),
            'gameEndType' => $game->getGameOption(),
            'endGamePointsRequired' => $game->getType() - $mainPlayerData->getPointsTotal(),
            'controller_name' => 'GameController'
        ]);
    }

}
