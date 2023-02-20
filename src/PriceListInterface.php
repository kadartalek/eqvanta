<?php

namespace Kadartalek\Eqvanta;

interface PriceListInterface extends \Traversable
{
    public function current(): PathSegmentInterface;
}
