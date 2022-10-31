<?php

namespace App\Validator;

use App\Entity\Game;
use App\Entity\Player;
use App\Exceptions\GameThrowInvalidException;
use App\Repository\GameThrowRepository;

class GameThrowValidator
{
    protected array $singlePoints;

    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
        $this->singlePoints = array_merge(range(0, 20), [25]);
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

    public function checkifPlayerWon(Game $game, Player $player, int $points, bool $double, bool $triple): bool
    {
        if($double === true) {
            $points *= 2;
        } elseif ($triple === true) {
            $points *=3;
        }

        $recorderPoints = $this->gameThrowRepository->getRecorderPoints($game->getId(), $player->getId());
        if($recorderPoints === $points)
        {
            return true;
        }

        return false;
    }

    /**
     * @throws GameThrowInvalidException
     */
    private function validateThrow(Game $game, Player $player, int $points, bool $double, bool $triple): void
    {
        if($double === true) {
            $points *= 2;
        } elseif ($triple === true) {
            $points *=3;
        }

        //check if throw ends game
        $recorderPoints = $this->gameThrowRepository->getRecorderPoints($game->getId(), $player->getId());

        if ($recorderPoints) {
            if ($recorderPoints - $points < 0) {
                throw new GameThrowInvalidException('Last throw is not be greater than remaining points.');
            }

            //validate ending game throw
            if ($recorderPoints - $points === 0) {
                if (($double || $triple) && ($game->getGameOption() === GAME::SINGLE_OUT)) {
                    throw new GameThrowInvalidException('Last throw is not single.');
                }
                if (((!$double && !$triple) || $triple) && ($game->getGameOption() === GAME::DOUBLE_OUT)) {
                    throw new GameThrowInvalidException('Last throw is not double.');
                }
            }

            if ($recorderPoints - $points === 1 && ($game->getGameOption() === GAME::DOUBLE_OUT)) {
                throw new GameThrowInvalidException('Invalid throw for "Double Out" because remaining points "1", can not be obtained with double throw.');
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