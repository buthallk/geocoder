<?php

namespace Tests\Location\Polygon;

use App\Modules\Location\Builders\PolygonBuilder;
use App\Modules\Location\Polygon\Point;
use App\Modules\Location\Polygon\Polygon;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;

class MapCoordinatesTest extends TestCase
{
    /**
     * @dataProvider pointsProviderForMapCoordinates
     */
    public function testMapCoordinates(array $points)
    {
        //Точка внутри зоны
        $polygon = $this->buildPoligon($points)->build();
        $this->assertEquals(true, $polygon->contains(new Point(42.508956, 27.483328)));

        //Точка снаружи зоны
        $polygon = $this->buildPoligon($points)->build();
        $this->assertEquals(false, $polygon->contains(new Point(43.499148, 24.485)));
    }

    private function buildPoligon(array $points): PolygonBuilder
    {
        $builder = Polygon::builder();

        foreach ($points as $point) {
            $builder->addVertex($point);
        }

        return $builder;
    }

    #[Pure] private function pointsProviderForMapCoordinates(): array
    {
        return
            [
                [
                    [
                        new Point(42.499148, 27.485196),
                        new Point(42.498600, 25.485196),
                        new Point(42.503800, 27.474680),
                        new Point(42.510000, 27.468270),
                        new Point(42.510788, 27.466904),
                        new Point(42.512116, 27.465350),
                        new Point(42.512000, 27.467000),
                        new Point(42.513579, 27.471027),
                        new Point(42.512938, 27.472668),
                        new Point(42.511829, 27.474922),
                        new Point(42.507945, 27.480124),
                        new Point(42.509082, 27.482892),
                        new Point(42.536026, 27.490519),
                        new Point(42.534470, 27.499703),
                        new Point(42.499148, 27.485196)
                    ]
                ],
            ];
    }
}
