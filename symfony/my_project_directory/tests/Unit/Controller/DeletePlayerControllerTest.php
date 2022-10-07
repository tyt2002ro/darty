<?php


use App\Controller\DeletePlayerController;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePlayerControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function verifyDeletingAnExistentPlayer(): void
    {
        $id = 12;
        $player = new Player();

        $deletePlayerController = new DeletePlayerController();

        $persistenceManagerRegistry = $this->prophesize(PersistenceManagerRegistry::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(Router::class);

        $deletePlayerController->setContainer($container->reveal());

        $persistenceManagerRegistry->getManager()->shouldBeCalled()->willReturn($objectManager->reveal());
        $objectManager->getRepository(Player::class)->shouldBeCalled()->willReturn($objectRepository->reveal());
        $objectRepository->find($id)->shouldBeCalled()->willReturn($player);
        $container->get('router')->shouldBeCalled()->willReturn($router->reveal());
        $router->generate(Argument::cetera())->shouldBeCalled()->willReturn('playerManagement');
        $objectManager->remove($player)->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $result = $deletePlayerController->delete($persistenceManagerRegistry->reveal(), $id);
        self::assertSame('playerManagement', $result->getTargetUrl());
    }

    /**
     * @test
     */
    public function verifyDeletingAnInexistentPlayer(): void
    {
        $id = 124;
        $player = null;

        $deletePlayerController = new DeletePlayerController();

        $persistenceManagerRegistry = $this->prophesize(PersistenceManagerRegistry::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(Router::class);

        $deletePlayerController->setContainer($container->reveal());

        $persistenceManagerRegistry->getManager()->shouldBeCalled()->willReturn($objectManager->reveal());
        $objectManager->getRepository(Player::class)->shouldBeCalled()->willReturn($objectRepository->reveal());
        $objectRepository->find($id)->shouldBeCalled()->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $result = $deletePlayerController->delete($persistenceManagerRegistry->reveal(), $id);
    }
}
