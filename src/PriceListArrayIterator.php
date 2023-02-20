<?php

namespace Kadartalek\Eqvanta;

class PriceListArrayIterator extends \ArrayIterator implements PriceListInterface
{
    public function __construct(object|array $array = [], int $flags = 0)
    {
        $first = \reset($array);

        if (!($first instanceof PriceListInterface)) {
            $array = \array_map(static function ($v) {
                return new PathSegment($v[0] ?? $v['length'], $v[1] ?? $v['price']);
            }, $array);
        }

        parent::__construct($array, $flags);
    }

    public function current(): PathSegmentInterface
    {
        return parent::current();
    }
}
