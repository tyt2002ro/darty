<?php

namespace App\tests\Unit;

use App\Controller\PlayerManagementScreenController;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
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

        $objectRepository = $this->prophesize(ObjectRepository::class);
        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $managerRegistry
            ->getRepository(Player::class)
            ->shouldBeCalled()
            ->willReturn($objectRepository->reveal());

        $playerManagementScreenController = new PlayerManagementScreenController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $playerManagementScreenController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        $pageContent = $playerManagementScreenController->playerManagementScreenAction($managerRegistry->reveal())->getContent();
        self::assertSame($content, $pageContent);
    }
}
