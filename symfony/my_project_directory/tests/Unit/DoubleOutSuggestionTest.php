<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\Controller\DoubleOutSuggestionController;


use App\Services\DoubleOutCalculation;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

final class DoubleOutSuggestionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function doubleOutActionReturnsTemplate(): void
    {
        $content = 'some content';
        $playerManagementScreenController = new DoubleOutSuggestionController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $playerManagementScreenController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $playerManagementScreenController->doubleOutAction()->getContent());
    }

    /**
     * @test
     */
    public function doubleOutPostReturnsTempalte(): void
    {
        $content = 'some content';
        $playerManagementScreenController = new DoubleOutSuggestionController();
        $twigTemplate = $this->prophesize(Environment::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('twig')->shouldBeCalled()->willReturn(true);
        $container->get('twig')->shouldBeCalled()->willReturn($twigTemplate->reveal());
        $playerManagementScreenController->setContainer($container->reveal());
        $twigTemplate->render(Argument::cetera())->shouldBeCalled()->willReturn($content);

        self::assertSame($content, $playerManagementScreenController->getDoubleOutOptionsAction(new Request())->getContent());
    }

    /**
     * @test
     */
    public function firstArraySum(): void
    {
        $request = new Request();
        $randomEndNumber = rand(2, 120);
        $request->attributes->set('points', $randomEndNumber);

        $doubleOutCalculation = new DoubleOutCalculation();
        $returns = $doubleOutCalculation->returnEndOptions($randomEndNumber);

        self::assertEquals($randomEndNumber, array_sum(explode(",",$returns[0],3)));
    }
}
