<?php

namespace Kadartalek\Eqvanta;

class PriceListArrayIterator extends \ArrayIterator implements PriceListInterface
{
    public function current(): PathSegmentInterface
    {
        return parent::current();
    }
}
