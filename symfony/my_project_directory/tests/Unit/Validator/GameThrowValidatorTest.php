<?php

namespace App\tests\Unit;

use App\Entity\Game;
use App\Entity\Player;
use App\Exceptions\GameThrowInvalidException;
use App\Repository\GameThrowRepository;
use App\Validator\GameThrowValidator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class GameThrowValidatorTest extends TestCase
{
    use ProphecyTrait;
    private GameThrowValidator $gameThrowValidator;

    public function setUp(): void
    {
        $this->gameThrowRepository = $this->prophesize(GameThrowRepository::class);
        $this->gameThrowValidator = new GameThrowValidator($this->gameThrowRepository->reveal());
    }

    /**
     * @test
     */
    public function checkSinglePoints(): void
    {
        self::assertTrue($this->gameThrowValidator->validatePoints(new Game(), new Player(), 5, false, false));
    }

    /**
     * @test
     */
    public function checkDoublePoints(): void
    {
        self::assertTrue($this->gameThrowValidator->validatePoints(new Game(), new Player(), 20, true, false));
    }

    /**
     * @test
     */
    public function checkTriplePoints(): void
    {
        self::assertTrue($this->gameThrowValidator->validatePoints(new Game(), new Player(), 21, false, true));
    }

    /**
     * @test
     */
    public function checkNegativePoints(): void
    {
        $this->expectException(GameThrowInvalidException::class);

        $this->gameThrowValidator->validatePoints(new Game(), new Player(), -21, false, true);
    }

    /**
     * @test
     */
    public function checkInvalidPoints(): void
    {

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints(new Game(), new Player(), 201, false, true);
    }

    /**
     * @test
     */
    public function checkValidEndingSingleOutGameThrow(): void
    {
        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn(10);

        $result = $this->gameThrowValidator->validatePoints(new Game(), new Player(), 10, false, false);

        self::assertTrue($result);
    }

    /**
     * @test
     * player must end a single out game with a single
     */
    public function checkValidLastSingleOutGameThrow(): void
    {
        //single score
        $gameOption = 'Single-Out';
        $double = false;
        $triple = false;

        $scoredPoints = 10;
        $remainingPoints = 10;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $result = $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);

        self::assertTrue(true, $result);
    }

    /**
     * @test
     * player cannot end a game with points greater than remaining points
     */
    public function checkInvalidLastSingleOutGameThrow(): void
    {
        //single score
        $gameOption = 'Single-Out';
        $double = false;
        $triple = false;

        $scoredPoints = 19;
        $remainingPoints = 10;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     * player cannot end a single out game with a double
     */
    public function checkInvalidDoubleForLastSingleOutGameThrow(): void
    {
        $gameOption = 'Single-Out';
        $double = true;
        $triple = false;

        $scoredPoints = 5;
        $remainingPoints = 10;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     * player cannot end a single out game with a triple
     */
    public function checkInvalidTripleForLastSingleOutGameThrow(): void
    {
        $gameOption = 'Single-Out';
        $double = false;
        $triple = true;

        $scoredPoints = 5;
        $remainingPoints = 15;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     * player must end a double out game with a double
     */
    public function checkValidLastDoubleOutGameThrow(): void
    {
        $gameOption = 'Double-Out';
        $double = true;
        $triple = false;

        $scoredPoints = 3;
        $remainingPoints = 6;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $result = $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);

        self::assertTrue(true, $result);
    }

    /**
     * @test
     * player cannot end a double out game with a single
     */
    public function checkInvalidSingleForLastDoubleOutGameThrow(): void
    {
        $gameOption = 'Double-Out';
        $double = false;
        $triple = false;

        $scoredPoints = 6;
        $remainingPoints = 6;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     * player cannot end a double out game with a triple
     */
    public function checkInvalidTripleForLastDoubleOutGameThrow(): void
    {
        $gameOption = 'Double-Out';
        $double = false;
        $triple = true;

        $scoredPoints = 4;
        $remainingPoints = 12;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     * in a double out game cannot remain 1 point because then the player cannot end with a double anymore
     */
    public function checkAnotherInvalidThrowForLastDoubleOutGameThrow(): void
    {
        $gameOption = 'Double-Out';
        $double = true;
        $triple = false;

        $scoredPoints = 6;
        $remainingPoints = 13;

        $game = new Game();
        $game->setGameOption($gameOption);

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);

        $this->expectException(GameThrowInvalidException::class);
        $this->gameThrowValidator->validatePoints($game, new Player(), $scoredPoints, $double, $triple);
    }

    /**
     * @test
     */
    public function checkIfPlayerWon(): void
    {
        $double = true;
        $triple = false;

        $scoredPoints = 7;
        $remainingPoints = '0';

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);
        $playerWon = $this->gameThrowValidator->checkifPlayerWon(new Game(), new Player(), $scoredPoints, $double, $triple);

        self::assertTrue($playerWon);
    }

    /**
     * @test
     */
    public function checkIfPlayerDidNotWon(): void
    {
        $double = false;
        $triple = false;

        $scoredPoints = 12;
        $remainingPoints = 14;

        $this->gameThrowRepository->getRecorderPoints(Argument::cetera())->shouldBeCalled()->willReturn($remainingPoints);
        $playerWon = $this->gameThrowValidator->checkifPlayerWon(new Game(), new Player(), $scoredPoints, $double, $triple);

        self::assertFalse($playerWon);
    }
}
