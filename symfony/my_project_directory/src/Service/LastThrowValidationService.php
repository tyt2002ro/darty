<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\Player;
use App\Repository\GameThrowRepository;

class LastThrowValidationService
{
    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    public function validateThrow(Game $game, Player $player, int $points, bool $double, bool $triple): int
    {
        //check if throw ends game
        $recorderPoints = $this->gameThrowRepository->getRecorderPoints($game->getId(), $player->getId());

        if ($recorderPoints) {
            $doubleOutCalculationService = new DoubleOutCalculationService();
            //validate ending game throw
            if ($recorderPoints - $points === 0) {
                //validate single
                if (($double || $triple)
                    && ($game->getType() === GAME::SINGLE_OUT)
                    && in_array($points, $doubleOutCalculationService->getDoubleOutNumbers(), true)) {
                    return 'Last throw is not single.';
                }

                //validate double
                if (($game->getType() === GAME::DOUBLE_OUT) &&
                    ($double || in_array($points, $doubleOutCalculationService->getDoubleOutNumbers(), true))) {
                    return 'Last throw is not double.';
                }
            }

            //if double game is set and remaining points, after current throw is 1, throw is invalid
            //we need a double number to end the game and 1 can't be obtained with a double point throw
            if ($recorderPoints - $points === 0 && ($game->getType() === GAME::DOUBLE_OUT)) {
                return 'Invalid throw for "Double Out" because remaining points "1", can not be obtained with double throw.';
            }
        }
    }
}