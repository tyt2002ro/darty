<?php

use App\Controller\GameThrowController;
use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Service\GameThrowService;
use App\Service\LastThrowValidationService;
use App\Validator\GameThrowValidator;
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
        $gameThrowValidator = $this->prophesize(GameThrowValidator::class);
        $gameThrowController = new GameThrowController($gameThrowService->reveal(),$gameThrowValidator->reveal());
        $gameThrowValidator->validatePoints(Argument::cetera())->shouldBeCalled()->willReturn(1);

        $gameThrowService->addGameThrow(Argument::cetera())->shouldBeCalled()->willReturn(new GameThrow());
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
