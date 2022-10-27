<?php

namespace App\Validator;

use App\Entity\Game;
use App\Entity\Player;
use App\Exceptions\GameThrowInvalidException;
use App\Repository\GameThrowRepository;
use App\Service\DoubleOutCalculationService;

class GameThrowValidator
{
    protected array $singlePoints;

    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
        $this->singlePoints = array_merge(range(1, 20), [25]);
    }

    /**
     * @throws GameThrowInvalidException
     */
    public function validatePoints(Game $game, Player $player, int $points, bool $double, bool $triple): bool
    {
        $this->validateThrow($game, $player, $points,  $double, $triple);

        if (in_array($points, $this->getAllAvailablePoints(), true)) {
            return true;
        }
        throw new GameThrowInvalidException();
    }

    /**
     * @throws GameThrowInvalidException
     */
    private function validateThrow(Game $game, Player $player, int $points, bool $double, bool $triple): void
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
                    throw new GameThrowInvalidException('Last throw is not single.');
                }

                //validate double
                if (($game->getType() === GAME::DOUBLE_OUT) &&
                    ($double || in_array($points, $doubleOutCalculationService->getDoubleOutNumbers(), true))) {
                    throw new GameThrowInvalidException('Last throw is not double.');
                }
            }

            //if double game is set and remaining points, after current throw is 1, throw is invalid
            //we need a double number to end the game and 1 can't be obtained with a double point throw
            if ($recorderPoints - $points === 0 && ($game->getType() === GAME::DOUBLE_OUT)) {
                throw new GameThrowInvalidException(
                    'Invalid throw for "Double Out" because remaining points "1", can not be obtained with double throw.');
            }
        }
    }





    private function getAllAvailablePoints(): array
    {
        $availablePoints = array_merge($this->getSinglePoints(), $this->getDoublePoints(), $this->getTriplePoints());

        return array_unique($availablePoints);
    }

    private function getSinglePoints(): array
    {
        return $this->singlePoints;
    }

    private function getDoublePoints(): array
    {
        return array_map(static function ($item): float|int {
            return $item * 2;
        }, $this->singlePoints);
    }

    private function getTriplePoints(): array
    {
        return array_diff(array_map(static function ($item): float|int {
            return $item * 3;
        }, $this->singlePoints), [75]);
    }
}