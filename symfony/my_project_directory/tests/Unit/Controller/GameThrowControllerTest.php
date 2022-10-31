<?php

use App\Controller\GameThrowController;
use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Service\GameService;
use App\Service\GameThrowService;
use App\Validator\GameThrowValidator;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GameThrowControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkAddThrow(): void
    {
        $request = new Request();
        $request->request->set('points', 1 );
        $request->request->set('double', true);
        $request->request->set('triple', false);

        $gameThrowService = $this->prophesize(GameThrowService::class);
        $gameThrowValidator = $this->prophesize(GameThrowValidator::class);
        $gameService = $this->prophesize(GameService::class);
        $container = $this->prophesize(ContainerInterface::class);
        $requestStack = $this->prophesize(RequestStack::class);
        $session = $this->prophesize(Session::class);
        $flashBagInterface = $this->prophesize(FlashBagInterface::class);

        $gameThrowController = new GameThrowController($gameThrowService->reveal(),$gameThrowValidator->reveal(), $gameService->reveal());
        $gameThrowController->setContainer($container->reveal());
        $gameThrowValidator->validatePoints(Argument::cetera())->shouldBeCalled()->willReturn(1);

        $gameThrowService->addGameThrow(Argument::cetera())->shouldBeCalled()->willReturn(new GameThrow());
        $gameThrowValidator->checkifPlayerWon(Argument::cetera())->shouldBeCalled()->willReturn(true);

        $container->get('request_stack')->shouldBeCalled()->willReturn($requestStack->reveal());
        $requestStack->getSession()->shouldBeCalled()->willReturn($session->reveal());
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBagInterface->reveal());
        $flashBagInterface->add(Argument::cetera())->shouldBeCalled();

        $gameService->getPlayerPlace(Argument::any(),1)->shouldBeCalled()->willReturn(1);
        $player = $this->prophesize(Player::class);
        $player->getId()->shouldBeCalled()->willReturn(1);

        $result = $gameThrowController->addThrow($request, new Game(), $player->reveal());

        self::assertSame('/game/', $result->getTargetUrl());
    }

    /**
     * @test
     */
    public function checkUndoGameThrow(): void
    {
        $gameThrowService = $this->prophesize(GameThrowService::class);
        $gameThrowValidator = $this->prophesize(GameThrowValidator::class);
        $gameService = $this->prophesize(GameService::class);

        $gameThrowController = new GameThrowController($gameThrowService->reveal(), $gameThrowValidator->reveal(), $gameService->reveal());
        $result = $gameThrowController->undo(new Game(), new Player());

        self::assertSame('/game/', $result->getTargetUrl());
    }
}
