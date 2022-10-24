<?php
declare(strict_types=1);

namespace App\tests\Factory;

use App\Entity\Game;
use App\Entity\Player;
use App\Factory\GameFactory;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;

final class GameFactoryTest extends TestCase
{


    /**
     * @test
     */
    public function createGameFactory(): void
    {
        $expectedGame = new Game();
        $expectedGame->setGameOption('SingleOut');
        $expectedGame->setType(302);
        $expectedGame->addPlayerId(new Player());
        $expectedGame->addPlayerId(new Player());


        $playerRepository = $this->prophesize(PlayerRepository::class);
        $gameFactory = new GameFactory($playerRepository->reveal());
        $playerRepository->find('3')->shouldBeCalled()->willReturn(new Player());
        $playerRepository->find('4')->shouldBeCalled()->willReturn(new Player());
        $game = $gameFactory->createGame(302, [3,4], 'SingleOut');

        self::assertEquals($expectedGame, $game);
    }

}
