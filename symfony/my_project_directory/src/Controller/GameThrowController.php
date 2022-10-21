<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Factory\GameThrowFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverte;

class GameThrowController extends AbstractController
{
    public function __construct(private readonly GameThrowFactory $gameThrowFactory)
    {
    }

    #[Route('/add/throw/{game_id}/{player_id}', name: 'app_game_throw', methods: ['POST'])]
    public function addThrow(Request $request, ManagerRegistry $doctrine, Game $game_id, Player $player_id): Response
    {
        $entityManager = $doctrine->getManager();

        $gameThrow = $this->gameThrowFactory->createFromValues(...);
        $points = $request->get('points');
        $double = $request->get('double');
        $triple = $request->get('triple');

        if($double === '1') {
            $points *=2;
        }
        if($triple === '1') {
           $points *=3;
        }

        $gameThrow->setPlayerId($player_id);
        $gameThrow->setGameId($game_id);
        $gameThrow->setPoints($points);
        $gameThrow->setThrowOrder(1);

        $entityManager->persist($gameThrow);
        $entityManager->flush();

        return $this->redirect('/game/'.$game_id->getId(), 301);
    }
}
