<?php

namespace App\Controller;

use App\Entity\Player;
use App\Service\DeletePlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePlayerController extends AbstractController
{
    #[Route('/player/delete/{id}', name: 'delete_player')]
    public function delete(DeletePlayerService $deletePlayerService, Player $player): Response
    {
        $deletePlayerService->delete($player);

        return $this->redirectToRoute('playerManagement');
    }
}
