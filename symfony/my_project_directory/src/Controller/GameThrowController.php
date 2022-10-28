<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Service\GameThrowService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameThrowController extends AbstractController
{
    public function __construct(private readonly GameThrowService $gameThrowService)
    {
    }

    #[Route('/add/throw/{game}/{player}', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, Game $game, Player $player): Response
    {
        $points = $request->get('points');
        $double = $request->get('double');
        $triple = $request->get('triple');

        $this->gameThrowService->addGameThrow($points, $double, $triple, $player, $game);

        return $this->redirect('/game/' . $game->getId(), 301);
    }

    #[Route('/undo/throw/{game}/{player}', name: 'undo_game_throw', methods: ['POST'])]
    public function undo(Game $game, Player $player): Response
    {
        $this->gameThrowService->undo($player, $game);

        return $this->redirect('/game/' . $game->getId(), 301);
    }
}
