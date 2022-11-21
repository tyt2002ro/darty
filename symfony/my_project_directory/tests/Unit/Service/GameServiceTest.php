<?php

use App\Entity\Game;
use App\Entity\Player;
use App\Factory\GameFactory;
use App\Repository\GameRepository;
use App\Service\GameService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class GameServiceTest extends TestCase
{
    use ProphecyTrait;

    private $gameRepositoryMock;
    private $gameFactoryMock;

    public function setUp(): void
    {
        $this->gameRepositoryMock = $this->prophesize(GameRepository::class);
        $this->gameFactoryMock = $this->prophesize(GameFactory::class);
        $this->gameService = new GameService($this->gameRepositoryMock->reveal(), $this->gameFactoryMock->reveal());
    }
    /**
     * @test
     */
    public function checkCreateGame(): void
    {
        $type = 301;
        $playerIds = [5, 6];
        $endOptions = 'Single';

        $gameMock = $this->prophesize(Game::class);
        $this->gameRepositoryMock->save($gameMock->reveal(), true)->shouldBeCalled();
        $this->gameFactoryMock->createGame($type, $playerIds, $endOptions, [1 => 98, 2 => null, 3 => 6])
            ->shouldBeCalled()
            ->willReturn($gameMock->reveal());
        $createdGame = $this->gameService->createGame($type, $playerIds, $endOptions, [1 => 98, 2 => null, 3 => 6]);
        
        self::assertEquals($gameMock->reveal(), $createdGame);
    }

    /**
     * @test
     */
    public function getPlayersPlaceTest(): void
        {
            $gameMock = $this->prophesize(Game::class);
            $gameMock->getPlayersPlace()->shouldBeCalled()->willReturn([1=>2, 2=>1]);
            $gameMock->setPlayersPlace([1=>3, 2=>1])->shouldBeCalled()->willReturn($gameMock->reveal());

            $result = $this->gameService->getPlayerPlace($gameMock->reveal(), 1);

            self::assertSame(3, $result);
        }

    /**
     * @test
     */
    public function checkFor2ndPlaceCongratsMessage(): void
    {
        $playerPlace = 2;
        $message = $this->gameService->getCongratsMessage($playerPlace);
        $expectedMessage ='Congrats! You reached 2nd place';
        self::assertSame($expectedMessage, $message);
    }

    /**
     * @test
     */
    public function checkFor1stPlaceCongratsMessage(): void
    {
        $playerPlace = 1;
        $message = $this->gameService->getCongratsMessage($playerPlace);
        $expectedMessage ='You won!';
        self::assertSame($expectedMessage, $message);
    }

    /**
     * @test
     */
    public function checkFor3rdPlaceCongratsMessage(): void
    {
        $playerPlace = 3;
        $message = $this->gameService->getCongratsMessage($playerPlace);
        $expectedMessage ='Congrats! You reached 3rd place';
        self::assertSame($expectedMessage, $message);
    }

    /**
     * @test
     */
    public function checkFor4thPlaceCongratsMessage(): void
    {
        $playerPlace = 4;
        $message = $this->gameService->getCongratsMessage($playerPlace);
        $expectedMessage ='Congrats! You reached 4th place';
        self::assertSame($expectedMessage, $message);
    }
}
