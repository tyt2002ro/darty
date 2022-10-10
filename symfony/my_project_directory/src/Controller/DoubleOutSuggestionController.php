<?php

namespace App\Controller;

use App\Services\DoubleOutCalculation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class DoubleOutSuggestionController extends AbstractController
{
    #[Route('/doubleOutOptions', name: 'doubleOutPost', methods: ['POST'])]
    public function getDoubleOutOptionsAction(Request $request): Response
    {
        $points = $request->request->get('points');

        $options = new DoubleOutCalculation();
        $endOptions = $options->returnEndOptions((int)$points);

        return $this->render('darty/doubleEndOptions.html.twig',
            parameters: ['options' => $endOptions]);
    }

    #[Route('/doubleOutOptions', name: 'doubleOut', methods: ['GET'])]
    public function doubleOutAction(): Response
    {
        return $this->render('darty/doubleEndOptions.html.twig', parameters: ['options' => []]);
    }
}