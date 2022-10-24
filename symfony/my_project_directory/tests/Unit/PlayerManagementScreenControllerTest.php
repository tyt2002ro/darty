<?php

namespace App\tests\Unit;

use App\Controller\PlayerManagementScreenController;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

class PlayerManagementScreenControllerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @test
     */
    public function playerManagementActionsReturnsTemplate(): void
    {
        $content = 'some content';

        $playerRepository = $this->prophesize(PlayerRepository::class);

        $playerManagementScreenController = new PlayerManagementScreenController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $playerManagementScreenController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        $pageContent = $playerManagementScreenController->playerManagementScreenAction($playerRepository->reveal())->getContent();
        self::assertSame($content, $pageContent);
    }
}
