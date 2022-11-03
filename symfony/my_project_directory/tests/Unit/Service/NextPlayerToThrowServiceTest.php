<?php

namespace App\tests\Unit;

use App\DataObjects\PlayerThrowData;
use App\Entity\Player;
use App\Repository\GameThrowRepository;
use App\Service\NextPlayerToThrowService;
use PHPUnit\Framework\TestCase;
use App\Entity\Game;
use Prophecy\PhpUnit\ProphecyTrait;

class NextPlayerToThrowServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     *  todo
     */
    public function checkReturnNextPlayerToThrow(): void
    {
        $playersData = [];
        $gameThrowRepository = $this->prophesize(GameThrowRepository::class);
        $nextPlayerToThrowService = new NextPlayerToThrowService($gameThrowRepository->reveal());
        $expectedReturn = $nextPlayerToThrowService->returnNextPlayerToThrow(new Game(),$playersData);

        self::assertInstanceOf(PlayerThrowData::class, $expectedReturn);

//        $game = $this->prophesize(Game::class);
//
//        $player = $this->prophesize(Player::class);
//        $players = [$player->reveal(), $player->reveal()];
//        $game->getSortedById()->shouldBeCalled()->willReturn($players);
//
//        $gameThrowRepository = $this->prophesize(GameThrowRepository::class);
//        $gameThrowRepository->findPlayerDataForThrow(33,443)->shouldBeCalled()->willReturn([]);
//
//        $nextPlayerToThrowService->updatePlayersData(44, $players, $playersData)->shouldBeCalled()->willReturn($expectedReturn);
//        $nextPlayerToThrowService->returnNextPlayerToThrow($game->reveal(), $playersData)->shouldBeCalled()->willReturn($expectedReturn);
//
//        $game = $this->prophesize(Game::class);
//
//        $gameThrowRepository = $this->prophesize(GameThrowRepository::class);
//        $nextPlayerToThrowService = new NextPlayerToThrowService($gameThrowRepository->reveal());


//        $game->getSortedById()->shouldBeCalled()->willReturn($players);
//        $game->getId()->shouldBeCalled()->willReturn(1);
//        $gameThrowRepository->findPlayerDataForThrow(1998898989,1312321321321321)->shouldBeCalled()->willReturn([1,2,3]);
//
//        $nextPlayerToThrowService = new NextPlayerToThrowService($gameThrowRepository->reveal());
//
//        $player_id = 1;
//        $order = 1;
//        $name = 'name1';
//        $pointsTotal = 5;
//        $pointsAverage = 10.5;
//        $legThrows = 5;
//        $totalThrows = 8;
//        $playerThrowData = new PlayerThrowData($player_id, $order, $name, $pointsTotal, $pointsAverage, $legThrows, $totalThrows);
//        $playersData = [$playerThrowData];
//        self::assertInstanceOf(PlayerThrowData::class, $nextPlayerToThrowService->returnNextPlayerToThrow($game->reveal(), $playersData));

            self::assertTrue(true);
    }
}
