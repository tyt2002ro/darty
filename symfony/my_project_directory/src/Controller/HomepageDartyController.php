<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageDartyController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepageAction(PlayerRepository $playerRepository): Response
    {
        $players = $playerRepository->findAll();

        $gameTypes = [
            ['type' => '301', 'checked' => false],
            ['type' => '401', 'checked' => false],
            ['type' => '501', 'checked' => true],
            ['type' => '601', 'checked' => false],
            ['type' => '701', 'checked' => false],
            ['type' => '801', 'checked' => false],
            ['type' => '901', 'checked' => false],
        ];

        $gameEnds = [
            ['type' => 'Single-Out', 'checked' => false],
            ['type' => 'Double-Out', 'checked' => true]
        ];

        return $this->render('darty/startPage.html.twig', [
            'players' => $players,
            'games' => $gameTypes,
            'gameEnds' => $gameEnds,
        ]);
    }
}
