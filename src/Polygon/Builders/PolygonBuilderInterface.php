<?php

namespace Geocoder\Polygon\Builders;

use Geocoder\Polygon\Geometry\Point;
use Geocoder\Polygon\Geometry\Polygon;

interface PolygonBuilderInterface
{
    public function addVertex(Point $point):self;
    public function close():self;
    public function build():Polygon;
}
