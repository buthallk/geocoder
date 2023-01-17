<?php

namespace Geocoder\Polygon\Geometry;

class Line
{
    private float $a;
    private float $b;
    private bool $isVertical = false;

    public function __construct(private Point $start, private Point $end)
    {
        if ($this->end->x - $this->start->x != 0) {
            $this->a = (($this->end->y - $this->start->y) / ($this->end->x - $this->start->x));
            $this->b = $this->start->y - ($this->a * $this->start->x);
        } else {
            $this->isVertical = true;
        }
    }

    public function isInside(Point $point): bool
    {
        $maxX = max($this->start->x, $this->end->x);
        $minX = min($this->start->x, $this->end->x);
        $maxY = max($this->start->y, $this->end->y);
        $minY = min($this->start->y, $this->end->y);

        if (
            ($point->x >= $minX && $point->x <= $maxX) &&
            ($point->y >= $minY && $point->y <= $maxY)
        ) {
            return true;
        }

        return false;
    }

    public function getA(): float
    {
        return $this->a;
    }

    public function getB(): float
    {
        return $this->b;
    }

    public function isVertical(): bool
    {
        return $this->isVertical;
    }

    public function getStart(): Point
    {
        return $this->start;
    }

    public function getEnd(): Point
    {
        return $this->end;
    }
}
