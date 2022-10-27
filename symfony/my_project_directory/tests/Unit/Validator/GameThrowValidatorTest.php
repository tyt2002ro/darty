<?php

namespace App\tests\Unit;

use App\Entity\Game;
use App\Entity\Player;
use App\Repository\GameThrowRepository;
use App\Validator\GameThrowValidator;
use PHPUnit\Framework\TestCase;
use App\Exceptions\GameThrowInvalidException;
use Prophecy\PhpUnit\ProphecyTrait;

class GameThrowValidatorTest extends TestCase
{
    use ProphecyTrait;
    private GameThrowValidator $gameThrowValidator;

    public function setUp(): void
    {
        $gameThrow = $this->prophesize(GameThrowRepository::class);
        $this->gameThrowValidator = new GameThrowValidator($gameThrow->reveal());
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


}
