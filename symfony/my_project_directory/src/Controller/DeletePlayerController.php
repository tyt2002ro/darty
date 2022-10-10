<?php

namespace App\Controller;

use App\Service\DeletePlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePlayerController extends AbstractController
{
    #[Route('/delete/player/{id}', name: 'delete_player')]
    public function delete(DeletePlayerService $deletePlayerService, int $id): Response
    {
        $deletePlayerService->deleteById($id);

        return $this->redirectToRoute('playerManagement');
    }
}
