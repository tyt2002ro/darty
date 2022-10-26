<?php

namespace App\Service;

use App\Repository\GameThrowRepository;

class LastThrowValidationService
{
    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    public function validateThrow($game, $player, $points, $double, $triple): int
    {
        //check if throw ends game
        $recorderPoints = $this->gameThrowRepository->getRecorderPoints($game->getId(),$player->getId());
        if($recorderPoints && ($recorderPoints - $points === 0)){
            //validate single
            if($double || $triple){
                return 'Last throw is not single.';
            }
        }
    }


}