<?php

use App\Controller\AddPlayerController;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

final class AddPlayerControllerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     * @dataProvider postDataProvider
     */
    public function buildPlayerActionFromRequest($data): void
    {
        $request = new Request([], [], $data);

        $addPlayerController = new AddPlayerController();

        $playerRepository = $this->prophesize(PlayerRepository::class);
        $container = $this->prophesize(ContainerInterface::class);
        $formFactory = $this->prophesize(FormFactory::class);
        $form = $this->prophesize(FormInterface::class);
        $player = $this->prophesize(Player::class);

        $addPlayerController->setContainer($container->reveal());

        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory->reveal());
        $formFactory->create(Argument::cetera())->shouldBeCalled()->willReturn($form->reveal());
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form->reveal());
        $form->isSubmitted()->shouldBeCalled()->willReturn(true);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $form->getData()->shouldBeCalled()->willReturn($player->reveal());

        $result = $addPlayerController->buildPlayerAction($playerRepository->reveal(), $request);
        self::assertSame('/', $result->getTargetUrl());

    }

    public function postDataProvider()
    {
        return [
            [
                ['firstName' => 'Alex',
                    'lastname' => 'Alex1',
                    'nickname' => 'Alex12'],
            ]
        ];
    }
}
