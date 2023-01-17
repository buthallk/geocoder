<?php

namespace Geocoder\Polygon\Services;

use Geocoder\Polygon\Geometry\Point;

interface PolygonServiceInterface
{
    public function contains(array $polygonCoordinates, Point $point): bool;
}
