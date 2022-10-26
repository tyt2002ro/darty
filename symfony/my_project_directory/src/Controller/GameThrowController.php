<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Service\LastThrowValidationService;
use App\Service\GameThrowService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverte;

class GameThrowController extends AbstractController
{
    public function __construct(private readonly GameThrowService $gameThrowService, private readonly LastThrowValidationService $lastThrowValidationService)
    {
    }

    #[Route('/add/throw/{game}/{player}', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, Game $game, Player $player): Response
    {
        $points = $request->get('points');
        $double = $request->get('double');
        $triple = $request->get('triple');

        $message = $this->lastThrowValidationService->validateThrow($game, $player, $points, $double, $triple);
        $this->addFlash('notice', $message);

        if(!$message) {
            $this->gameThrowService->addGameThrow($points, $double, $triple, $player, $game);
        }

        return $this->redirect('/game/' . $game->getId(), 301);
    }
}
