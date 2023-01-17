<?php

namespace App\Polygon\Geometry;

use ArrayIterator;
use Generator;

class Polygon
{
    public function __construct(private ArrayIterator $slides, private BoundingBox $boundingBox)
    {
    }

    public function contains(Point $point):bool
    {
        if ($this->inBoundingBox($point)) {
            $ray = $this->createRay($point);
            $intersection = 0;

            foreach ($this->getSides() as $side) {
                if ($this->intersect($ray, $side)) {
                    $intersection++;
                }
            }

            if ($intersection % 2 != 0) {
                return true;
            }
        }

        return false;
    }

    private function getSides(): Generator
    {
        foreach ($this->slides as $slide) {
            yield $slide;
        }
    }

    private function inBoundingBox(Point $point): bool
    {
        if (
            $point->x < $this->boundingBox->xMin ||
            $point->x > $this->boundingBox->xMax ||
            $point->y < $this->boundingBox->yMin ||
            $point->y > $this->boundingBox->yMax
        ) {
            return false;
        }

        return true;
    }

    private function createRay(Point $point): Line
    {
        $epsilon = ($this->boundingBox->xMax - $this->boundingBox->xMin)/10e6;
        $outsidePoint = new Point($this->boundingBox->xMin - $epsilon, $this->boundingBox->yMin);

        return new Line($outsidePoint, $point);
    }

    private function intersect(Line $ray, Line $side): bool
    {
        if (!$ray->isVertical() && !$side->isVertical()) {
            if ($ray->getA() - $side->getA() == 0) {
                return false;
            }

            $x = (
                ($side->getB() - $ray->getB()) /
                ($ray->getA() - $side->getA())
            );
            $y = $side->getA() * $x + $side->getB();
            $intersectPoint = new Point($x, $y);
        } elseif ($ray->isVertical() && !$side->isVertical()) {
            $x = $ray->getStart()->x;
            $y = $side->getA() * $x + $side->getB();

            $intersectPoint = new Point($x, $y);
        } elseif (!$ray->isVertical() && $side->isVertical()) {
            $x = $side->getStart()->x;
            $y = $ray->getA() * $x + $ray->getB();

            $intersectPoint = new Point($x, $y);
        } else {
            return false;
        }

        if ($side->isInside($intersectPoint) && $ray->isInside($intersectPoint)) {
            return true;
        }

        return false;
    }
}
