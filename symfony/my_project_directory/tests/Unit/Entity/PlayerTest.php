<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Player;

class PlayerTest extends TestCase
{
    /**
     * @test
     */
    public function checkFirstName(): void
    {
        $expectedFirstname = 'John';

        $player = new Player();
        $player->setFirstname($expectedFirstname);

        self::assertSame($expectedFirstname, $player->getFirstname());
    }

    /**
     * @test
     */
    public function checkLastName(): void
    {
        $expectedLastname = 'Doe';

        $player = new Player();
        $player->setLastname($expectedLastname);

        self::assertSame($expectedLastname, $player->getLastname());
    }

    /**
     * @test
     */
    public function checkNickName(): void
    {
        $expectedNickname = 'Test';

        $player = new Player();
        $player->setNickname($expectedNickname);

        self::assertSame($expectedNickname, $player->getNickname());
    }
}