<?php


use App\Controller\DeletePlayerController;
use App\Entity\Player;
use App\Service\DeletePlayerService;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePlayerControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkDeleteController(): void
    {
        $id = 12;

        $deletePlayerService = $this->prophesize(DeletePlayerService::class);
        $container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(Router::class);

        $container->get('router')->shouldBeCalled()->willReturn($router->reveal());
        $router->generate(Argument::cetera())->shouldBeCalled()->willReturn('playerManagement');

        $deletePlayerController = new DeletePlayerController();
        $deletePlayerController->setContainer($container->reveal());

        $result = $deletePlayerController->delete($deletePlayerService->reveal(),$id);

        self::assertSame('playerManagement', $result->getTargetUrl());
    }
}
