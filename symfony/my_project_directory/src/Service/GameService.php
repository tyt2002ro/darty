<?php

namespace App\Service;

use App\Repository\GameRepository;

class GameService
{


    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

}