<?php
declare(strict_types=1);

namespace App\tests\Factory;

use App\Factory\GameThrowFactory;
use PHPUnit\Framework\TestCase;
use App\Entity\Player;
use App\Entity\Game;
use Prophecy\PhpUnit\ProphecyTrait;

final class GameThrowFactoryTest extends TestCase
{
    use ProphecyTrait;
    protected function setUp(): void
    {
        $this->factory = new GameThrowFactory();
        $this->player = new Player();
        $this->game = new Game();
    }

    /**
     * @test
     */
    public function createReturnNewGameThrowSingleOne(): void
    {
        $throw = $this->factory->createFromValues(1, false, false, $this->player, $this->game);

        self::assertSame(1, $throw->getPoints());
    }

    /**
     * @test
     */
    public function createReturnNewGameThrowDoubleOne(): void
    {
        $throw = $this->factory->createFromValues(1, true, false, $this->player, $this->game);

        self::assertSame(2, $throw->getPoints());
    }

    /**
     * @test
     */
    public function createReturnNewGameThrowTripleOne(): void
    {
        $throw = $this->factory->createFromValues(1, false, true, $this->player, $this->game);

        self::assertSame(3, $throw->getPoints());
    }
}
