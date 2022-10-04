<?php


use App\Controller\AddPlayerController;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

final class AddPlayerControllerTest extends TestCase
{
    /**
     * @test
     */
    public function buildPlayerActionFromRequest(): void
    {
        $persistenceManagerRegistry = $this->prophesize(PersistenceManagerRegistry::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $addPlayerController = new AddPlayerController();
        $request = new Request();
        $request->attributes->set('firstname', 'Alex');
        $request->attributes->set('lastname', 'Alex1');
        $request->attributes->set('nickname', 'Alex12');
        $persistenceManagerRegistry->getManager()->shouldBeCalled()->willReturn($objectManager->reveal());
        $objectManager->persist(Argument::any())->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('form.factory')->shouldBeCalled();

        $result = $addPlayerController->buildPlayerAction($persistenceManagerRegistry->reveal(), $request);
        self::assertSame('/', $result->getTargetUrl());

    }
}
