<?php


use App\DataObjects\PlayerThrowData;
use PHPUnit\Framework\TestCase;

class PlayerThrowDataTest extends TestCase
{

    /**
     * @test
     */
    public function checkDataObjectProperties(): void
        {

            $player_id = 1;
            $order = 1;
            $name = 'name1';
            $pointsTotal = 5;
            $pointsAverage = 10.5;
            $legThrows = 5;
            $totalThrows = 8;
            $playerThrowData = new PlayerThrowData($player_id, $order, $name, $pointsTotal, $pointsAverage, $legThrows, $totalThrows);

            self::assertSame($player_id, $playerThrowData->getPlayerId());
            self::assertSame($order, $playerThrowData->getOrder());
            self::assertSame($name, $playerThrowData->getName());
            self::assertSame($pointsTotal, $playerThrowData->getPointsTotal());
            self::assertSame($pointsAverage, $playerThrowData->getPointsAverage());
            self::assertSame($legThrows, $playerThrowData->getLegThrows());
            self::assertSame($totalThrows, $playerThrowData->getTotalThrows());

        }
}
