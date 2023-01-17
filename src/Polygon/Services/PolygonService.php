<?php

namespace Geocoder\Polygon\Services;

use Geocoder\Polygon\Builders\PolygonBuilder;
use Geocoder\Polygon\Geometry\Point;
use Geocoder\Polygon\Geometry\Polygon;
use Generator;

class PolygonService implements PolygonServiceInterface
{
    public function contains(array $polygonCoordinates, Point $point): bool
    {
        return $this->buildPoligon($polygonCoordinates)->contains($point);
    }

    private function buildPoligon(array $polygonCoords): Polygon
    {
        $polygonBuilder = new PolygonBuilder();

        foreach ($this->getPolygonCoordPoints($polygonCoords) as $coordPoint) {
            $polygonBuilder->addVertex($coordPoint);
        }

        return $polygonBuilder->build();
    }

    private function getPolygonCoordPoints(array $polygonCoords):Generator
    {
        foreach ($polygonCoords as $polygonCoord) {
            yield new Point($polygonCoord[0], $polygonCoord[1]);
        }
    }
}
