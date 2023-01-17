<?php

namespace App\Polygon\Builders;

use App\Polygon\Exceptions\PolygonException;
use App\Polygon\Geometry\BoundingBox;
use App\Polygon\Geometry\Line;
use App\Polygon\Geometry\Point;
use App\Polygon\Geometry\Polygon;
use ArrayIterator;

class PolygonBuilder implements PolygonBuilderInterface
{
    private ArrayIterator $vertexes;
    private ArrayIterator $sides;
    private bool $isFirstPoint = true;
    private bool $isClosed = false;
    private BoundingBox $boundingBox;

    public function __construct()
    {
        $this->vertexes = new ArrayIterator();
        $this->sides = new ArrayIterator();
    }

    public function addVertex(Point $point):self
    {
        if ($this->isClosed) {
            $this->vertexes = new ArrayIterator();
            $this->isClosed = false;
        }

        $this->updateBoundingBox($point);
        $this->vertexes->append($point);

        $size = $this->vertexes->count();

        if ($size > 1) {
            $line = new Line($this->vertexes->offsetGet($size - 2), $point);
            $this->sides->append($line);
        }

        return $this;
    }

    /**
     * @throws PolygonException
     */
    public function close():self
    {
        $this->validate();

        $this->sides->append(new Line(
            $this->vertexes->offsetGet($this->vertexes->count() - 1),
            $this->vertexes->offsetGet(0)
        ));

        $this->isClosed = true;
        return $this;
    }

    private function updateBoundingBox(Point $point)
    {
        if ($this->isFirstPoint) {
            $this->boundingBox = new BoundingBox();
            $this->boundingBox->xMax = $point->x;
            $this->boundingBox->xMin = $point->x;
            $this->boundingBox->yMax = $point->y;
            $this->boundingBox->yMin = $point->y;
            $this->isFirstPoint = false;
        } else {
            if ($point->x > $this->boundingBox->xMax) {
                $this->boundingBox->xMax = $point->x;
            } elseif ($point->x < $this->boundingBox->xMin) {
                $this->boundingBox->xMin = $point->x;
            }
            if ($point->y > $this->boundingBox->yMax) {
                $this->boundingBox->yMax = $point->y;
            } elseif ($point->y < $this->boundingBox->yMin) {
                $this->boundingBox->yMin = $point->y;
            }
        }
    }

    /**
     * @throws PolygonException
     */
    private function validate():void
    {
        if ($this->vertexes->count() < 3) {
            throw new PolygonException();
        }
    }

    /**
     * @throws PolygonException
     */
    public function build():Polygon
    {
        $this->validate();

        if (!$this->isClosed) {
            $this->sides->append(
                new Line(
                    $this->vertexes->offsetGet($this->vertexes->count() - 1),
                    $this->vertexes->offsetGet(0)
                )
            );
        }

        return new Polygon($this->sides, $this->boundingBox);
    }
}
