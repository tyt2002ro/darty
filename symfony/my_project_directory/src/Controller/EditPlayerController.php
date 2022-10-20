<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Service\EditPlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditPlayerController extends AbstractController
{
    private EditPlayerService $editPlayerService;

    public function __construct(EditPlayerService $editPlayerService)
    {
        $this->editPlayerService = $editPlayerService;
    }

    #[Route('/edit/player/{id}', name: 'app_edit_player', methods: ['GET'])]
    public function editPlayerFormAction(Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);

        return $this->renderForm('darty/editPlayer.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/edit/player/{id}', name: 'editPlayerAction', methods: ['post'])]
    public function editPlayerAction(Request $request, Player $player): RedirectResponse
    {
        $form = $this->createForm(PlayerType::class, $player);
        $this->editPlayerService->editAnExistentPlayer($form, $request);

        return $this->redirect('/player-management', 301);

    }
}
