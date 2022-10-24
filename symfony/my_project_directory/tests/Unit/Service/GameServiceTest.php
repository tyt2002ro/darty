<?php

use App\Entity\Game;
use App\Factory\GameFactory;
use App\Repository\GameRepository;
use App\Service\GameService;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    /**
     * @test
     */
    public function checkCreateGame(): void
    {
        $type = 301;
        $playerIds = [5, 6];
        $endOptions = 'Single';

        $gameRepository = $this->prophesize(GameRepository::class);
        $gameFactory = $this->prophesize(GameFactory::class);
        $game = $this->prophesize(Game::class);
        $gameService = new GameService($gameRepository->reveal(), $gameFactory->reveal());

        $gameFactory->createGame($type,$playerIds,$endOptions)->shouldBeCalled()->willReturn($game->reveal());
        $gameRepository->save($game->reveal(),true)->shouldBeCalled();
        $gameId = $gameService->createGame($type, $playerIds, $endOptions);

        self::assertSame(1, $gameId);
    }
}
