<?php

use App\Controller\GameThrowController;
use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Service\GameThrowService;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

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
        $gameThrow = $this->prophesize(GameThrow::class);
        $gameThrowController = new GameThrowController($gameThrowService->reveal());

        $gameThrowService->addGameThrow(Argument::cetera())->shouldBeCalled()->willReturn($gameThrow->reveal());

        $result = $gameThrowController->addThrow($request, new Game(), new Player());

        self::assertSame('/game/', $result->getTargetUrl());
    }

    /**
     * @test
     */
    public function checkUndoGameThrow(): void
    {
        $gameThrowService = $this->prophesize(GameThrowService::class);

        $gameThrowController = new GameThrowController($gameThrowService->reveal());
        $result = $gameThrowController->undo(new Game(), new Player());

        self::assertSame('/game/', $result->getTargetUrl());
    }
}
