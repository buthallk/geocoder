<?php

namespace App\Polygon\Builders;

use App\Polygon\Geometry\Point;
use App\Polygon\Geometry\Polygon;

interface PolygonBuilderInterface
{
    public function addVertex(Point $point):self;
    public function close():self;
    public function build():Polygon;
}
