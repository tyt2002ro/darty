<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Exceptions\GameThrowInvalidException;
use App\Service\GameThrowService;
use App\Validator\GameThrowValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverte;

class GameThrowController extends AbstractController
{
    public function __construct(private readonly GameThrowService $gameThrowService,
                                private readonly GameThrowValidator $gameThrowValidator)
    {
    }

    #[Route('/add/throw/{game}/{player}', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, Game $game, Player $player): Response
    {
        $points = $request->get('points');
        $double = $request->get('double');
        $triple = $request->get('triple');

        try{
            $this->gameThrowValidator->validatePoints($game, $player, $points, $double, $triple);
            $this->gameThrowService->addGameThrow($points, $double, $triple, $player, $game);
        }
        catch(GameThrowInvalidException $e)
        {
            $this->addFlash('notice', $e->getMessage());
        }

        return $this->redirect('/game/' . $game->getId(), 301);
    }
}
