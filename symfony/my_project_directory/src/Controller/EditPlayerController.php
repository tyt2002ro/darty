<?php

namespace App\Controller;

use App\Exceptions\PlayerNotExistException;
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

    /**
     * @throws PlayerNotExistException
     */
    #[Route('/edit/player/{playerId}', name: 'app_edit_player', methods: ['GET'])]
    public function editPlayerFormAction(int $playerId): Response
    {
        $player = $this->editPlayerService->getPlayerFromDb($playerId);
        $form = $this->createForm(PlayerType::class, $player);

        return $this->renderForm('darty/editPlayer.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws PlayerNotExistException
     */
    #[Route('/edit/player/{playerId}', name: 'editPlayerAction', methods: ['post'])]
    public function editPlayerAction(Request $request, $playerId): RedirectResponse
    {
        $player = $this->editPlayerService->getPlayerFromDb($playerId);

        $form = $this->createForm(PlayerType::class, $player);
        $this->editPlayerService->editAnExistentPlayer($form, $request);

        return $this->redirect('/player-management', 301);

    }
}
