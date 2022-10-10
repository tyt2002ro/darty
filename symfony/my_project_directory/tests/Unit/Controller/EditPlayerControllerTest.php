<?php
use App\Controller\EditPlayerController;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Prophecy\Argument;
use Symfony\Component\Form\FormView;
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

        $result = $editPlayerController->editPlayerFormAction($managerRegistryMock->reveal(),$player->getId());
        self::assertSame($content,$result->getContent());
    }
}
