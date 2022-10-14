<?php

use App\Controller\DeletePlayerController;
use App\Entity\Player;
use App\Service\DeletePlayerService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Router;

class DeletePlayerControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function verifyDeletePlayer(): void
    {
        $deletePlayerService = $this->prophesize(DeletePlayerService::class);
        $container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(Router::class);
        $player = $this->prophesize(Player::class);

        $deleteController = new DeletePlayerController();
        $deleteController->setContainer($container->reveal());

        $container->get('router')->shouldBeCalled()->willReturn($router->reveal());
        $router->generate(Argument::cetera())->shouldBeCalled()->willReturn('playerManagement');

        $result = $deleteController->delete($deletePlayerService->reveal(), $player->reveal());

        self::assertSame('playerManagement', $result->getTargetUrl());

    }
}
