<?php

namespace App\Service;

use App\Repository\PlayerRepository;

class EditPlayerService
{

    public function __construct(private readonly PlayerRepository $playerRepository)
    {
    }

    public function editAnExistentPlayer($form, $request): void
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player = $form->getData();

            $this->playerRepository->save($player, true);
        }
    }
}