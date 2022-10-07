<?php

namespace App\Controller;

use DoubleOutCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class DoubleOutSuggestionController extends AbstractController
{
    #[Route('/doubleOutOptions', name: 'doubleOutPost', methods: ['POST'])]
    public function buildPlayerAction(Request $request): Response
    {
        $points = $request->request->get('points');

        $endOptions = [];
        if (is_numeric($points)) {
            $options = new DoubleOutCalculation();
            $options->returnEndOptions($points);
            $endOptions = $options->returnEndOptions($points);
        }

        return $this->render('darty/doubleEndOptions.html.twig',
            parameters: ['options' => $endOptions]);
    }

    #[Route('/doubleOutOptions', name: 'doubleOut', methods: ['GET'])]
    public function doubleOutAction(): Response
    {
        return $this->render('darty/doubleEndOptions.html.twig', parameters: ['options' => []]);
    }
}