<?php
declare(strict_types=1);

namespace App\tests\Factory;

use App\Factory\GameFactory;
use App\Factory\GameThrowFactory;
use App\Repository\GameRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use App\Entity\Player;
use App\Entity\Game;

final class GameFactoryTest extends TestCase
{


    /**
     * @test
     */
    public function createGameFactory(): void
    {
        $gameRepository = $this->prophesize(GameRepository::class);
        $game = new GameFactory($gameRepository->reveal());
        $throw = $this->factory->createFromValues(1, false, false, $this->player, $this->game);

        self::assertSame(1, $throw->getPoints());
    }

}
