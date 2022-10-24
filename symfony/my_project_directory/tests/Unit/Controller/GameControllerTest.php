<?php

use App\Controller\GameController;
use App\Entity\Game;
use App\Service\GameService;
use App\Service\NextPlayerToThrowService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\Request;

final class GameControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkAddGame(): void
    {
        $players = [6, 7];
        $request = new Request();
        $request->request->set('games', '301');
        $request->request->set('gameEnds', 'test');
        $request->request->set('player', $players);

        $nextPlayerToThrowService = $this->prophesize(NextPlayerToThrowService::class);
        $gameService = $this->prophesize(GameService::class);
        $gameController = new GameController($nextPlayerToThrowService->reveal(), $gameService->reveal());


        $game = $this->prophesize(Game::class);
        $gameService->createGame(Argument::cetera())->shouldBeCalled()->willReturn($game->reveal());

        $result = $gameController->create($request);
        self::assertSame('/game/', $result->getTargetUrl());
    }
}
