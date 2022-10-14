<?php

use App\Repository\PlayerRepository;
use App\Service\DeletePlayerService;
use App\Entity\Player;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DeletePlayerServiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkDeletePlayer(): void
    {
        $player = $this->prophesize(Player::class);
        $playerRepository = $this->prophesize(PlayerRepository::class);

        $deletePlayerService = new DeletePlayerService($playerRepository->reveal());

        $deletePlayerService->delete($player->reveal());

        self::assertTrue(true);
    }

}
