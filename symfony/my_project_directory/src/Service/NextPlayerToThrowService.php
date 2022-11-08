<?php

namespace App\Service;

use App\DataObjects\PlayerThrowData;
use App\Entity\Game;
use App\Exceptions\PlayerNotExistException;
use App\Repository\GameThrowRepository;

class NextPlayerToThrowService
{
    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    /**
     * @throws PlayerNotExistException
     */
    public function returnNextPlayerToThrow(Game $game, array &$playersData): PlayerThrowData
    {
        $players = $game->getSortedById();

        if(!$players){
            return new PlayerThrowData(0,0,'',0,0,0,0);
        }

        $this->updatePlayersData($game->getId(), $players, $playersData);

        foreach ($playersData as $playerData) {
            //if not all 3 throws, from leg, were thrown, player still has throws
            if ($playerData->getLegThrows() !== 3 && ($game->getType() !== $playerData->getPointsTotal())) {
                return $playerData;
            }
        }

        //if no player has throws let, we select the first player for given order, with the lowest throws.
        usort($playersData, fn($a, $b) => strcmp($a->getOrder(), $b->getOrder()));
        usort($playersData, fn($a, $b) => strcmp($a->getTotalThrows(), $b->getTotalThrows()));

        return $this->getNextPlayer($playersData, $game);
    }

    private function updatePlayersData(int $gameId, array $players, array &$playersData): void
    {
        foreach ($players as $order => $player) {
            $dbData = $this->gameThrowRepository->findPlayerDataForThrow(
                $gameId, $player->getId());
            $playersData[] = new PlayerThrowData($player->getId(),
                order: (int)$dbData['throwOrder'],
                name: $player->getFirstname() . ' ' . $player->getLastname(),
                pointsTotal: $dbData['pointsTotal'],
                pointsAverage: $dbData['pointsAverage'],
                legThrows: $dbData['legThrows'],
                totalThrows: $dbData['totalThrows']
            );
        }
    }

    public function returnOtherPlayerData(array $playersData, int $order): array
    {
        foreach ($playersData as $newOrder => $subArray) {
            if ($order === $subArray->getOrder()) {
                unset($playersData[$newOrder]);
            }
        }
        return $playersData;
    }

    private function getNextPlayer(array $playersData, Game $game): PlayerThrowData
    {
        foreach($playersData as $playerData)
        {
            if($game->getType() !== $playerData->getPointsTotal())
            {
                return $playerData;
            }
        }
        return '';

    }
}

