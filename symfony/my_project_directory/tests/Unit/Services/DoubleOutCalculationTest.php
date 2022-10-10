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
        $request = new Request();
        $randomEndNumber = rand(2, 120);
        $request->attributes->set('points', $randomEndNumber);

        $doubleOutCalculation = new DoubleOutCalculation();
        $returns = $doubleOutCalculation->returnEndOptions($randomEndNumber);

        self::assertEquals($randomEndNumber, array_sum(explode(",",$returns[0],3)));
    }
}
