<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\Controller\DoubleOutSuggestionController;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class DoubleOutSuggestionControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function doubleOutActionReturnsTemplate(): void
    {
        $content = 'some content';
        $doubleOutSuggestionController = new DoubleOutSuggestionController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $doubleOutSuggestionController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $doubleOutSuggestionController->doubleOutAction()->getContent());
    }

    /**
     * @test
     */
    public function doubleOutPostReturnsTemplate(): void
    {
        $content = 'some content2';
        $requestData = new Request();
        $requestData->request->set('points', rand(2, 120));
        $doubleOutSuggestionController = new DoubleOutSuggestionController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $doubleOutSuggestionController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $doubleOutSuggestionController->getDoubleOutOptionsAction($requestData)->getContent());
    }
}
