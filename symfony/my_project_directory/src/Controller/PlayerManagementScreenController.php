<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PlayerManagementScreenController extends AbstractController
{
    #[Route('/player-management', name: 'playerManagement')]
    public function playerManagementScreenAction(): Response
    {
        $players = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'nickname' => 'jdoe'
            ],
            [
                'firstname' => 'Same',
                'lastname' => 'Name',
                'nickname' => 'sname'
            ],
            [
                'firstname' => 'Max',
                'lastname' => 'Mustermann',
                'nickname' => 'mmustermann'
            ],
            [
                'firstname' => 'Tudor',
                'lastname' => 'Eu',
                'nickname' => 'teu'
            ],
            [
                'firstname' => 'Erika',
                'lastname' => 'Mustermann',
                'nickname' => 'emustermann'
            ],
        ];
        return $this->render('darty/playerManagementScreen.html.twig', [
            'players' => $players
        ]);

    }
}