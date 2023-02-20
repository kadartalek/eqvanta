<?php

namespace Kadartalek\Eqvanta;


interface PathSegmentInterface
{
    public function segmentPrice(): string;

    public function segmentLength(): int;
}
