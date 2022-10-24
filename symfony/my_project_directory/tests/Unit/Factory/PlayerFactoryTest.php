<?php

namespace App\tests\Factory;

use App\Entity\Player;
use App\Factory\PlayerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class PlayerFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkPlayerFactory(): void
    {
        $firstName = 'John';
        $lastName = 'Doe';
        $nickname = 'jdoe';

        $playerFactory = new PlayerFactory();
        $player = $playerFactory->createPlayer($firstName, $lastName, $nickname);

        self::assertInstanceOf(Player::class, $player);
        self::assertSame($firstName, $player->getFirstname());
        self::assertSame($lastName, $player->getLastname());
        self::assertSame($nickname, $player->getNickname());
    }
}
