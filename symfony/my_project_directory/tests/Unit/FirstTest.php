<?php declare(strict_types=1);

namespace App\test\Unit;

use PHPUnit\Framework\TestCase;

final class FirstTest extends TestCase
{
    /**
     * @test
     */
    public function first(): void
    {
        self::assertTrue('Never trust a test you didn\'t see failing');
    }
}
