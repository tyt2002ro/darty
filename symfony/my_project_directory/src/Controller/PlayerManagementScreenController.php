<?php

namespace App\Controller;

use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayerManagementScreenController extends AbstractController
{
    #[Route('/player-management', name: 'playerManagement')]
    public function playerManagementScreenAction(ManagerRegistry $managerRegistry): Response
    {
        $players = $managerRegistry->getRepository(Player::class)->findAll();

        return $this->render('darty/playerManagementScreen.html.twig', [
            'players' => $players
        ]);

    }
}