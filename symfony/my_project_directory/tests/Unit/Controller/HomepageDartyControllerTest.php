<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\Controller\HomepageDartyController;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

final class HomepageDartyControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function homepageActionsReturnsTemplate(): void
    {
        $content = 'some content';

        $playerRepository = $this->prophesize(PlayerRepository::class);

        $homepageDartyController = new HomepageDartyController();
        $twig = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twig->reveal());
        $homepageDartyController->setContainer($container->reveal());
        $twig->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $homepageDartyController->homepageAction($playerRepository->reveal())->getContent());
    }
}
