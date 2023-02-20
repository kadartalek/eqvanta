<?php

namespace Kadartalek\Eqvanta;

class PathSegment implements PathSegmentInterface
{
    private int $segmentLength;
    private string $segmentPrice;

    public function __construct(int $segmentLength, string $segmentPrice)
    {
        $this->segmentLength = $segmentLength;
        $this->segmentPrice = $segmentPrice;
    }

    public function segmentPrice(): string
    {
        return $this->segmentPrice;
    }

    public function segmentLength(): int
    {
        return $this->segmentLength;
    }
}
