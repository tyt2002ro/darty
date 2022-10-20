<?php


use App\Controller\GameController;
use App\Entity\Player;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

final class GameControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function checkAddGame(): void
    {
        $players = [6,7];
        $request = new Request();
        $request->request->set('games', '301');
        $request->request->set('gameEnds', 'test');
        $request->request->set('player', $players);

        $gameController = new GameController();

        $persistenceManagerRegistry = $this->prophesize(PersistenceManagerRegistry::class);
        $objectRepository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);

        $persistenceManagerRegistry->getRepository(Player::class)->shouldBeCalled()->willReturn($objectRepository->reveal());
        foreach($players as $player)
        {
            $objectRepository->findOneBy(array('id' => $player))->shouldBeCalled()->willReturn(new Player);
        }

        $persistenceManagerRegistry->getManager()->shouldBeCalled()->willReturn($objectManager->reveal());

        $objectManager->persist(Argument::any())->shouldBeCalled();
        $objectManager->flush()->shouldBeCalled();

        $result = $gameController->create($persistenceManagerRegistry->reveal(), $request);
        self::assertSame('/', $result->getTargetUrl());
    }
}
