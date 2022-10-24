<?php

use App\Controller\EditPlayerController;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Service\EditPlayerService;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Prophecy\Argument;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class EditPlayerControllerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @test
     */
    public function editPlayerPageActionsReturnsTemplate(): void
    {
        $content = 'content';

        $player = new Player();
        $player->setFirstname("vadim");
        $player->setFirstname("tudor");
        $player->setFirstname("vtudor");

        $playerRepository = $this->prophesize(PlayerRepository::class);
        $containerMock = $this->prophesize(ContainerInterface::class);
        $formFactoryMock = $this->prophesize(FormFactory::class);
        $formInterfaceMock = $this->prophesize(FormInterface::class);
        $formViewMock = $this->prophesize(FormView::class);
        $twig = $this->prophesize(Environment::class);

        $editPlayerController = new EditPlayerController(new EditPlayerService($playerRepository->reveal()));

        $editPlayerController->setContainer($containerMock->reveal());
        $containerMock->get('form.factory')->shouldBeCalled()->willReturn($formFactoryMock->reveal());

        $formFactoryMock->create(Argument::cetera())->shouldBeCalled()->willReturn($formInterfaceMock->reveal());

        $formInterfaceMock->isSubmitted()->shouldBeCalled()->willReturn(true);
        $formInterfaceMock->isValid()->shouldBeCalled()->willReturn(true);
        $formInterfaceMock->createView()->shouldBeCalled()->willReturn($formViewMock->reveal());

        $containerMock->has('twig')->shouldBeCalled()->willReturn(true);
        $containerMock->get('twig')->shouldBeCalled()->willReturn($twig->reveal());

        $twig->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        $result = $editPlayerController->editPlayerFormAction($player);
        self::assertSame($content, $result->getContent());
    }

    /**
     * @test
     */
    public function editPlayerActionFromRequest(): void
    {
        $expectedUrl = '/player-management';

        $player = new Player();
        $request = new Request();

        $container = $this->prophesize(ContainerInterface::class);
        $formFactory = $this->prophesize(FormFactory::class);
        $formInterface = $this->prophesize(FormInterface::class);
        $playerMock = $this->prophesize(Player::class);
        $playerRepository = $this->prophesize(PlayerRepository::class);

        $editPlayerController = new EditPlayerController(new EditPlayerService($playerRepository->reveal()));

        $editPlayerController->setContainer($container->reveal());
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory->reveal());
        $formFactory->create(Argument::cetera())->shouldBeCalled()->willReturn($formInterface->reveal());

        $formInterface->handleRequest($request)->shouldBeCalled()->willReturn($formInterface->reveal());
        $formInterface->isSubmitted()->shouldBeCalled()->willReturn(true);
        $formInterface->isValid()->shouldBeCalled()->willReturn(true);
        $formInterface->getData()->shouldBeCalled()->willReturn($playerMock->reveal());

        $result = $editPlayerController->editPlayerAction($request, $player);
        self::assertSame($expectedUrl, $result->getTargetUrl());
    }
}
