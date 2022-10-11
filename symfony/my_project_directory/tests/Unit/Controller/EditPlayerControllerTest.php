<?php

use App\Controller\EditPlayerController;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Prophecy\Argument;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class EditPlayerControllerTest extends TestCase
{
    /**
     * @test
     */
    public function editPlayerPageActionsReturnsTemplate(): void
    {
        $content = 'content';

        $player = new Player();
        $player->setId(2);
        $player->setFirstname("vadim");
        $player->setFirstname("tudor");
        $player->setFirstname("vtudor");

        $editPlayerController = new EditPlayerController();

        $containerMock = $this->prophesize(ContainerInterface::class);
        $managerRegistryMock = $this->prophesize(ManagerRegistry::class);
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $formFactoryMock = $this->prophesize(FormFactory::class);
        $formInterfaceMock = $this->prophesize(FormInterface::class);
        $formViewMock = $this->prophesize(FormView::class);
        $twig = $this->prophesize(Environment::class);

        $managerRegistryMock->getRepository(Player::class)->shouldBeCalled()->willReturn($objectRepository->reveal());
        $objectRepository->find($player->getId())->shouldBeCalled()->willReturn($player);
        $editPlayerController->setContainer($containerMock->reveal());
        $containerMock->get('form.factory')->shouldBeCalled()->willReturn($formFactoryMock->reveal());

        $formFactoryMock->create(Argument::cetera())->shouldBeCalled()->willReturn($formInterfaceMock->reveal());

        $formInterfaceMock->isSubmitted()->shouldBeCalled()->willReturn(true);
        $formInterfaceMock->isValid()->shouldBeCalled()->willReturn(true);
        $formInterfaceMock->createView()->shouldBeCalled()->willReturn($formViewMock->reveal());

        $containerMock->has('twig')->shouldBeCalled()->willReturn(true);
        $containerMock->get('twig')->shouldBeCalled()->willReturn($twig->reveal());

        $twig->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        $result = $editPlayerController->editPlayerFormAction($managerRegistryMock->reveal(), $player->getId());
        self::assertSame($content, $result->getContent());
    }

    /**
     * @test
     * @throws \App\Exceptions\PlayerNotExistException
     */
    public function editPlayerActionFromRequest(): void
    {
        $expectedUrl = '/player-management';
        $playerId = 2;
        $player = new Player();
        $player->setId($playerId);

        $editPlayerController = new EditPlayerController();
        $request = new Request();

        $managerRegistry = $this->prophesize(ManagerRegistry::class);
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $container = $this->prophesize(ContainerInterface::class);
        $formFactory = $this->prophesize(FormFactory::class);
        $formInterface = $this->prophesize(FormInterface::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $playerMock = $this->prophesize(Player::class);

        $managerRegistry->getRepository(Player::class)->shouldBeCalled()->willReturn($objectRepository->reveal());
        $objectRepository->find($player->getId())->shouldBeCalled()->willReturn($player);
        $editPlayerController->setContainer($container->reveal());
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory->reveal());
        $formFactory->create(Argument::cetera())->shouldBeCalled()->willReturn($formInterface->reveal());

        $formInterface->handleRequest($request)->shouldBeCalled()->willReturn($formInterface->reveal());
        $formInterface->isSubmitted()->shouldBeCalled()->willReturn(true);
        $formInterface->isValid()->shouldBeCalled()->willReturn(true);
        $formInterface->getData()->shouldBeCalled()->willReturn($playerMock->reveal());

        $managerRegistry->getManager()->shouldBeCalled()->willReturn($objectManager->reveal());

        $objectManager->persist($playerMock->reveal())->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $result = $editPlayerController->editPlayerAction($managerRegistry->reveal(), $request, $playerId);
        self::assertSame($expectedUrl, $result->getTargetUrl());
    }
}
