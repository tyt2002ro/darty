<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DeletePlayerController extends AbstractController
{
    #[Route('/delete/player/{id}', name: 'delete_player')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $player = $entityManager->getRepository(Player::class)->find($id);

//        if (!$player) {
//            throw $this->createNotFoundException(
//                'No player found for id '.$id
//            );
//        }

        $entityManager->remove($player);
        $entityManager->flush();

        return $this->redirectToRoute('playerManagement');
    }
}
