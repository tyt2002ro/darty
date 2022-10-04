<?php

namespace App\Factory;

use App\Entity\Player;

final class PlayerFactory implements PlayerFactoryInterface
{
    public function createPlayer(string $firstname, string $lastname, string $nickname): Player
    {
        $player = new Player();

        $player->setFirstname($firstname);
        $player->setLastname($lastname);
        $player->setNickname($nickname);

        return $player;
    }

}