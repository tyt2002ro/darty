<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageDartyController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepageAction(ManagerRegistry $doctrine): Response
    {

        $playerList = $doctrine->getRepository(Player::class)->findAll();

        if (!$playerList) {
            $players = [
                ['name' => 'John Doe'],
                ['name' => 'Same Name'],
                ['name' => 'Max Mustermann'],
                ['name' => 'Tudor Eu'],
                ['name' => 'Erika Mustermann'],
            ];
        } else {

            foreach ($playerList as $player){
                $players[] = ['name' => $player->getFirstName().' '.$player->getLastName()];
            }
        }

        $gameTypes = [
            ['type' => '301', 'checked' => true],
            ['type' => '501', 'checked' => false]
        ];

        $gameEnds = [
            ['type' => 'Single-Out', 'checked' => true],
            ['type' => 'Double-Out', 'checked' => false]
        ];

        return $this->render('darty/startPage.html.twig', [
            'players' => $players,
            'games' => $gameTypes,
            'gameEnds' => $gameEnds,
        ]);
    }
}