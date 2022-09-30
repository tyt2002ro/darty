<?php

namespace App\tests\Unit;

use App\Controller\HomepageDartyController;
use PHPUnit\Framework\TestCase;
use App\Controller\PlayerManagementScreenController;
use Prophecy\Argument;
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

        $playerManagementScreenController = new PlayerManagementScreenController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $playerManagementScreenController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $playerManagementScreenController->playerManagementScreenAction()->getContent());
    }
}
