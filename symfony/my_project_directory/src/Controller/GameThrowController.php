<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Factory\GameThrowFactory;
use App\Repository\GameThrowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverte;

class GameThrowController extends AbstractController
{
    public function __construct(private readonly GameThrowFactory $gameThrowFactory, private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    #[Route('/add/throw/{game}/{player}', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, Game $game, Player $player): Response
    {
        $points = $request->get('points');
        $double = $request->get('double');
        $triple = $request->get('triple');

        $gameThrow = $this->gameThrowFactory->createFromValues($points, $double, $triple, $player, $game);

        $this->gameThrowRepository->save($gameThrow, true);

        return $this->redirect('/game/' . $game->getId(), 301);
    }
}
