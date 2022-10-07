<?php

namespace App\Service;

use App\Entity\Player;
use App\Exceptions\PlayerNotExistException;
use App\Form\PlayerType;

class EditPlayerService
{

    /**
     * @throws PlayerNotExistException
     */
    public function getPlayerFromDb($managerRegistry, $playerId): Player
    {
        $player = $managerRegistry->getRepository(Player::class)->find($playerId);
        if ($player !== null) {
            return $player;
        } else {
            throw new PlayerNotExistException("This player does not exist");
        }
    }
}