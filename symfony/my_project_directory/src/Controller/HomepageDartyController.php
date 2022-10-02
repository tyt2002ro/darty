<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageDartyController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepageAction(): Response
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