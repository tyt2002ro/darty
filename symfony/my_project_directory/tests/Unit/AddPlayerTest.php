<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\Controller\AddPlayerController;
use App\Controller\HomepageDartyController;
use App\Entity\Player;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

final class AddPlayerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function homepageActionsReturnsTemplate(): void
    {
        $content = 'some content';

        $addPlayerController = new AddPlayerController();
        $twig = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twig->reveal());
        $addPlayerController->setContainer($container->reveal());
        $twig->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $addPlayerController->addPlayerFormAction()->getContent());
    }

    /**
     * @test
     */
    public function buildPlayerReturnTemplate(): void
    {
        /**
         * TO DO
         * how PhpUnit tests a db insert function
         */

        self::assertSame(1, 1);
    }

    /**
     * @test
     */
    public function checkPlayerFirstName(): void
    {
        $player = new Player();
        $player->setFirstname("John");

        $this->assertEquals("John",  $player->getFirstname());
    }

    /**
     * @test
     */
    public function checkPlayerLastName(): void
    {
        $player = new Player();
        $player->setLastname("Doe");

        $this->assertEquals("Doe",  $player->getLastname());
    }

    /**
     * @test
     */
    public function checkPlayerNickName(): void
    {
        $player = new Player();
        $player->setNickname("Dev");

        $this->assertEquals("Dev",  $player->getNickname());
    }
}
