<?php declare(strict_types=1);

namespace App\tests\Unit;

use App\Services\DoubleOutCalculation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class DoubleOutCalculationTest extends TestCase
{

    /**
     * @test
     */
    public function firstArraySum(): void
    {
        $randomEndNumber = rand(2, 120);

        $doubleOutCalculation = new DoubleOutCalculation();
        $returns = $doubleOutCalculation->returnEndOptions($randomEndNumber);

        self::assertSame($randomEndNumber, $doubleOutCalculation->returnValueOfFormattedOption($returns));
    }
}
