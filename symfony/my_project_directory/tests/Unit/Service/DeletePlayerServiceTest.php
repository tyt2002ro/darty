<?php


use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Service\DeletePlayerService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Loader\Configurator\Traits\PropertyTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePlayerServiceTest extends TestCase
{
    use PropertyTrait;

    /**
     * @test
     */
    public function checkDeleteExistentPlayer(): void
    {
        $id = 1;
        $playerRepository = $this->prophesize(PlayerRepository::class);
        $playerRepository->findOneById($id)->shouldBeCalled()->willReturn(new Player());
        $playerRepository->remove(new Player(), true);

        $deletePlayerService = new DeletePlayerService($playerRepository->reveal());

        $deletePlayerService->deleteById($id);
    }

    /**
     * @test
     */
    public function checkDeleteNonExistentPlayer(): void
    {
        $id = 1;
        $playerRepository = $this->prophesize(PlayerRepository::class);
        $playerRepository->findOneById($id)->shouldBeCalled()->willReturn(null);

        $deletePlayerService = new DeletePlayerService($playerRepository->reveal());

        $this->expectException(NotFoundHttpException::class);

        $deletePlayerService->deleteById($id);
    }
}
