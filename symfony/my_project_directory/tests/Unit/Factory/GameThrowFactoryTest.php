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
        $throw = $factory->createFromValues(1, true, true, 1, 1);

        self::assertSame(1, $throw->getPoints());
    }
}
