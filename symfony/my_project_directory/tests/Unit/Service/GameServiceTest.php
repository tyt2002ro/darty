<?php

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
        $gameRepository = $this->prophesize(GameRepository::class);
        $gameFactory = $this->prophesize(GameFactory::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $gameService = new GameService($gameRepository->reveal(), $gameFactory->reveal(), $managerRegistry->reveal());
        $type = 301;
        $playerIds = [5, 6];
        $endOptions = 'Single';
        $game = $gameService->createGame($type, $playerIds, $endOptions);
        self::assertSame('Never trust a test you didn\'t see failing');
    }
}
