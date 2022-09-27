<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageDartyController extends AbstractController
{
    public function number(): Response
    {
        $players = [
            ['name' => 'John Doe'],
            ['name' => 'Same Name'],
            ['name' => 'Max Mustermann'],
            ['name' => 'Tudor Eu'],
            ['name' => 'Erika Mustermann'],
        ];

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