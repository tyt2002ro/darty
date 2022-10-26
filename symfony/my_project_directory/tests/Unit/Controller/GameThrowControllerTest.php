<?php

use App\Controller\GameThrowController;
use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Service\GameThrowService;
use App\Service\LastThrowValidationService;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        $container = $this->prophesize(ContainerInterface::class);
        $lastThrowValidationService = $this->prophesize(LastThrowValidationService::class);
        $requestStack = $this->prophesize(RequestStack::class);
        $flashBagInterface = $this->prophesize(FlashBagInterface::class);
        $session = $this->prophesize(Session::class);

        $gameThrowController = new GameThrowController($gameThrowService->reveal(),$lastThrowValidationService->reveal());

        $lastThrowValidationService->validateThrow(Argument::cetera())->shouldBeCalled()->willReturn(1);
        $gameThrowController->setContainer($container->reveal());
        $container->get('request_stack')->shouldBeCalled()->willReturn($requestStack->reveal());
        $requestStack->getSession()->shouldBeCalled()->willReturn($session->reveal());
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBagInterface->reveal());

        $result = $gameThrowController->addThrow($request, new Game(), new Player());

        self::assertSame('/game/', $result->getTargetUrl());
    }
}
