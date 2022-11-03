<?php
declare(strict_types=1);

namespace App\tests\Factory;

use App\Entity\Game;
use App\Entity\Player;
use App\Exceptions\PlayerNotExistException;
use App\Factory\GameFactory;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class GameFactoryTest extends TestCase
{
    use ProphecyTrait;

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
        $expectedGame->setThrowPlayersOrder([1 => 98, 2 => null, 3 => 6]);


        $playerRepository = $this->prophesize(PlayerRepository::class);
        $gameFactory = new GameFactory($playerRepository->reveal());
        $playerRepository->find('3')->shouldBeCalled()->willReturn(new Player());
        $playerRepository->find('4')->shouldBeCalled()->willReturn(new Player());
        $game = $gameFactory->createGame(302, [3,4], 'SingleOut', [1 => 98, 2 => null, 3 => 6]);

        self::assertEquals($expectedGame, $game);
    }

    /**
     * @test
     */
    public function generateExceptionGameFactory(): void
    {
        $expectedGame = new Game();
        $expectedGame->setGameOption('SingleOut');
        $expectedGame->setType(302);
        $expectedGame->addPlayerId(new Player());
        $expectedGame->addPlayerId(new Player());
        $expectedGame->setPlayersPlace(['3' => '0', '4' => '0']);

        $playerRepository = $this->prophesize(PlayerRepository::class);
        $gameFactory = new GameFactory($playerRepository->reveal());
        $playerRepository->find('3')->shouldBeCalled()->willReturn(null);

        $this->expectException(PlayerNotExistException::class);
        $gameFactory->createGame(302, [3,4], 'SingleOut', [1 => 98, 2 => null, 3 => 6]);
    }

}
