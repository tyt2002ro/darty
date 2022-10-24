<?php

use App\Entity\Game;
use App\Entity\Player;
use App\Factory\GameFactory;
use App\Repository\GameRepository;
use App\Service\GameService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class GameServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkCreateGame(): void
    {
        $type = 301;
        $playerIds = [5, 6];
        $endOptions = 'Single';

        $game = new Game();
        $game->setType($type);
        $game->setGameOption($endOptions);
        $game->addPlayerId(new Player());

        $expectedGame = new Game();
        $expectedGame->setType($type);
        $expectedGame->setGameOption($endOptions);
        $expectedGame->addPlayerId(new Player());

        $gameRepository = $this->prophesize(GameRepository::class);
        $gameFactory = $this->prophesize(GameFactory::class);
        $gameService = new GameService($gameRepository->reveal(), $gameFactory->reveal());

        $gameFactory->createGame(Argument::cetera())->shouldBeCalled()->willReturn($game);

        $createdGame = $gameService->createGame($type, $playerIds, $endOptions);
        
        self::assertEquals($expectedGame, $createdGame);
    }
}
