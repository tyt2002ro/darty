<?php

namespace App\Factory;

interface PlayerFactoryInterface
{
    public function createPlayer(string $firstname, string $lastname, string $nickname );

}