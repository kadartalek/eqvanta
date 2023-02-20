<?php

namespace tests\cases;

use Kadartalek\Eqvanta\DistancePriceCalculator;
use Kadartalek\Eqvanta\PathSegment;
use Kadartalek\Eqvanta\PathSegmentInterface;
use Kadartalek\Eqvanta\PriceListInterface;
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
                new class (\array_map(static function ($v) {
                    return new PathSegment($v[0], $v[1]);
                }, [
                    [100, '100'],
                    [200, '80'],
                    [1, '70'],
                ])) extends \ArrayIterator implements PriceListInterface {
                    public function current(): PathSegmentInterface
                    {
                        return parent::current();
                    }
                }
            ))->run(305)
        );
    }
}
