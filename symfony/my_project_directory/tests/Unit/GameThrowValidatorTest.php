<?php

namespace App\tests\Unit;

use App\GameThrowValidator;
use PHPUnit\Framework\TestCase;
use App\Exceptions\GameThrowInvalidException;

class GameThrowValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function checkSinglePoints(): void
    {
        $gameThrowValidator = new GameThrowValidator();
        self::assertTrue($gameThrowValidator->validatePoints(5));
    }

    /**
     * @test
     */
    public function checkDoublePoints(): void
    {
        $gameThrowValidator = new GameThrowValidator();
        self::assertTrue($gameThrowValidator->validatePoints(26));
    }

    /**
     * @test
     */
    public function checkTriplePoints(): void
    {
        $gameThrowValidator = new GameThrowValidator();
        self::assertTrue($gameThrowValidator->validatePoints(21));
    }

    /**
     * @test
     */
    public function checkNegativePoints(): void
    {
        $this->expectException(GameThrowInvalidException::class);
        $gameThrowValidator = new GameThrowValidator();

        $gameThrowValidator->validatePoints(-16);
    }

    /**
     * @test
     */
    public function checkInvalidPoints(): void
    {
        $gameThrowValidator = new GameThrowValidator();

        $this->expectException(GameThrowInvalidException::class);
        $gameThrowValidator->validatePoints(80);
    }


}
