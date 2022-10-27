<?php


use App\Entity\Game;
use App\Entity\GameThrow;
use App\Entity\Player;
use App\Factory\GameThrowFactory;
use App\Validator\GameThrowValidator;
use App\Repository\GameThrowRepository;
use PHPUnit\Framework\TestCase;
use App\Service\GameThrowService;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;

class GameThrowServiceTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @test
     */
    public function checkAddGameThrow(): void
    {
        $points = 1;

        $expectedGameThrow = new GameThrow();
        $expectedGameThrow->setPoints($points);
        $expectedGameThrow->setThrowOrder(1);
        $expectedGameThrow->setGame(new Game());
        $expectedGameThrow->setPlayer(new Player());

        $gameThrowFactory = $this->prophesize(GameThrowFactory::class);
        $gameThrowRepository = $this->prophesize(GameThrowRepository::class);
        $gameThrowValidator = $this->prophesize(GameThrowValidator::class);

        $player = $this->prophesize(Player::class);
        $game = $this->prophesize(Game::class);

        $gameThrowService = new GameThrowService(
            $gameThrowFactory->reveal(),
            $gameThrowRepository->reveal());

        $gameThrow = new GameThrow();
        $gameThrow->setPoints($points);
        $gameThrow->setThrowOrder(1);
        $gameThrow->setGame(new Game());
        $gameThrow->setPlayer(new Player());
//        $gameThrowValidator->validatePoints(new Game(), new Player(), 10,  false, false)->shouldBeCalled()->willReturn(true);
        $gameThrowFactory->createFromValues(Argument::cetera())->shouldBeCalled()->willReturn($gameThrow);

        $createdGameThrow = $gameThrowService->addGameThrow($points, true, false, $player->reveal(), $game->reveal());

        self::assertEquals($expectedGameThrow, $createdGameThrow);
    }

}
