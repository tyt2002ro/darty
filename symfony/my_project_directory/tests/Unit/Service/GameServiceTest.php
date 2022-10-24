<?php


use App\Repository\GameRepository;

use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    /**
     * @test
     */
    public function checkCreateGame(): void
    {
        $gameRepository = $this->prophesize(GameRepository::class);
        $gameService = new GameService($gameRepository->reveal());
        $type = 301;
        $playerIds = [5, 6];
        $endOptions = 'Single';
        $game = $gameService->createGame($type, $playerIds, $endOptions);
        self::assertSame('Never trust a test you didn\'t see failing');
    }
}
