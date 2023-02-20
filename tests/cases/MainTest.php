<?php

namespace tests\cases;

use Kadartalek\Eqvanta\DistancePriceCalculator;
use Kadartalek\Eqvanta\PriceListArrayIterator;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws \Kadartalek\Eqvanta\DistanceConfigError
     */
    public function testMain(): void
    {
        static::assertEquals(
            '26350.0000',
            (new DistancePriceCalculator(
                new PriceListArrayIterator([
                    [100, '100'],
                    [200, '80'],
                    [1, '70'],
                ])
            ))->run(305)
        );
    }
}
