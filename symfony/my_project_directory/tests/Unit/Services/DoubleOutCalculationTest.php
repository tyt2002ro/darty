<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\DataObjects\DoubleOutSuggestion;
use App\Services\DoubleOutCalculation;
use PHPUnit\Framework\TestCase;

final class DoubleOutCalculationTest extends TestCase
{

    /**
     * @test
     * @dataProvider doubleOutProvider
     */
    public function checkSuggestions(DoubleOutSuggestion $outSuggestion, int $score): void
    {
        $doubleOutCalculation = new DoubleOutCalculation();

        $expected = $outSuggestion;

        $actualSuggestion = $doubleOutCalculation->calculate($score);
        self::assertSame($expected->getFirstThrow(), $actualSuggestion->getFirstThrow());
        self::assertSame($expected->getSecondThrow(), $actualSuggestion->getSecondThrow());
        self::assertSame($expected->getThirdThrow(), $actualSuggestion->getThirdThrow());
    }


    public function doubleOutProvider(): iterable
    {
        yield 'score 160' => [new DoubleOutSuggestion('T20', 'T20', 'D20'), 160];
        yield 'score 2' => [new DoubleOutSuggestion('', '', 'D1'), 2];
        yield 'score 121' => [new DoubleOutSuggestion('T20', 'T7', 'D20'), 121];
        yield 'score 104' => [new DoubleOutSuggestion('T20', 'D2', 'D20'), 104];
    }

}
