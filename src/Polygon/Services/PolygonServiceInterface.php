<?php

namespace App\Polygon\Services;

use App\Polygon\Geometry\Point;

interface PolygonServiceInterface
{
    public function contains(array $polygonCoordinates, Point $point): bool;
}
