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

class GameController extends AbstractController
{
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
    public function index(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $game = $doctrine->getRepository(Game::class)->find($id);

        $players = $game->getSortedById();

        $playersData = [];
        foreach ($players as $order => $player){
            $playersData[] = array_merge($doctrine->getRepository(GameThrow::class)->findPlayerDataForThrow(
                $game->getId(), $player->getId()), ['player_id' => $player->getId(), 'order' => $order]);
        }

        $mainPlayerData = null;
        foreach ($playersData as $playerData){
            if($playerData['leftThrow'] !== 3){
                $mainPlayerData = $playerData;
            }
        }

        if(!$mainPlayerData){
            array_multisort(array_column($playersData, 'totalThrow'), SORT_ASC,
                array_column($playersData, 'order'),      SORT_ASC,
                $playersData);
            $mainPlayerData = $playersData[0];
        }
        
        $mainPlayerDataName = $players[$mainPlayerData['order']]->getFirstname().' '.$players[$mainPlayerData['order']]->getLastname();

        return $this->render('game/index.html.twig', [
            'player_id' => $mainPlayerData['player_id'],
            'mainPlayerData' => $mainPlayerData,
            'mainPlayerDataName' => $mainPlayerDataName,
            'game_id' => $id,
            'controller_name' => 'GameController'
        ]);
    }

}
