<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayerManagementScreenController extends AbstractController
{
    #[Route('/player-management', name: 'playerManagement')]
    public function playerManagementScreenAction(PlayerRepository $playerRepository): Response
    {
        $players = $playerRepository->findAll();

        return $this->render('darty/playerManagementScreen.html.twig', [
            'players' => $players
        ]);

    }
}