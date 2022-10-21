<?php

namespace App\Service;

use App\Repository\GameThrowRepository;

class NextPlayerToThrowService
{
    public function __construct(private readonly GameThrowRepository $gameThrowRepository)
    {
    }

    public function returnNextPlayerToThrow(int $game_id, array $players, array &$playersData): array
    {
        $this->updatePlayersData($game_id, $players, $playersData);

        $mainPlayerData = null;
        foreach ($playersData as $playerData) {
            //if not all 3 throws, from leg, were thrown, player still has throws
            if ($playerData['legThrows'] !== 3) {
                return $playerData;
            }
        }

        if (!$mainPlayerData) {
            //if no player has throws let, we select the first player for given order, with the lowest throws.
            array_multisort(array_column($playersData, 'totalThrows'), SORT_ASC,
                array_column($playersData, 'order'), SORT_ASC,
                $playersData);
            return $playersData[0];
        }
    }

    public function returnOtherPlayerData(array $playersData, mixed $order): array
    {
        foreach ($playersData as $newOrder => $subArray) {
            if ($subArray['order'] === $order) {
                unset($playersData[$newOrder]);
            }
        }
        return $playersData;
    }

    private function updatePlayersData(int $gameId, array $players, array &$playersData): void
    {
        foreach ($players as $order => $player) {
            $playersData[] = array_merge($this->gameThrowRepository->findPlayerDataForThrow(
                $gameId, $player->getId()),
                [
                    'player_id' => $player->getId(),
                    'order' => $order,
                    'name' => $player->getFirstname() . ' ' . $player->getLastname()
                ]);
        }
    }
}

