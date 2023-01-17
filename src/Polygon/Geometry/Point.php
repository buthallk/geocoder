<?php

namespace App\Polygon\Geometry;

class Point
{
    public function __construct(public float $x, public float $y)
    {
    }

    public function __toString(): string
    {
        return sprintf("(%f, %f)", $this->x, $this->y);
    }
}
