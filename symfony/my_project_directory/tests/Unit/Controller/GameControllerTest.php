<?php

use App\Controller\GameController;
use App\DataObjects\PlayerThrowData;
use App\Entity\Game;
use App\Service\GameService;
use App\Service\NextPlayerToThrowService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

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

    /**
     * @test
     */
    public function checkRenderTemplateGame(): void
    {
        $content = 'some content';

        $gameService = $this->prophesize(GameService::class);
        $nextPlayerToThrowService = $this->prophesize(NextPlayerToThrowService::class);
        $gameController = new GameController($nextPlayerToThrowService->reveal(), $gameService->reveal());

        $game = $this->prophesize(Game::class);
        $game->getId()->shouldBeCalled()->willReturn(1);

        $playerThrowData = $this->prophesize(PlayerThrowData::class);
        $playerThrowData->getOrder()->shouldBeCalled()->willReturn(1);
        $playerThrowData->getPlayerId()->shouldBeCalled()->willReturn(1);


        $playerData = [];
        $nextPlayerToThrowService
            ->returnNextPlayerToThrow($game,$playerData)
            ->shouldBeCalled()
            ->willReturn($playerThrowData->reveal());

        $nextPlayerToThrowService->returnOtherPlayerData([], 1)->shouldBeCalled()->willReturn([]);

        $twig = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twig->reveal());
        $gameController->setContainer($container->reveal());
        $twig->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $gameController->index($game->reveal())->getContent());
    }
}
