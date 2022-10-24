<?php
declare(strict_types=1);

namespace App\tests\Factory;

use App\Factory\GameThrowFactory;
use PHPUnit\Framework\TestCase;

final class GameThrowFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createReturnNewGameThrow(): void
    {
        $factory = new GameThrowFactory();
        $playerId = 5;
        $gameId = 1;
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $player = $objectRepository->findOneBy(array('id' => $playerId))->shouldBeCalled()->willReturn(new Player);
        $game = $objectRepository->findOneBy(array('id' => $gameId))->shouldBeCalled()->willReturn(new Game);


        $throw = $factory->createFromValues(1, true, true, $player, 1);

        self::assertSame(1, $throw->getPoints());
    }
}
