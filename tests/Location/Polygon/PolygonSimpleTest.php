<?php

namespace Tests\Location\Polygon;

use App\Modules\Location\Builders\PolygonBuilder;
use App\Modules\Location\Polygon\Point;
use App\Modules\Location\Polygon\Polygon;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;

class PolygonSimpleTest extends TestCase
{
    /**
     * @dataProvider pointsProviderForSimplePoligon
     */
    public function testSimplePolygon(array $points):void
    {
        //Точка внутри зоны
        $polygon = $this->buildPoligon($points)->build();
        $this->assertEquals(true, $polygon->contains(new Point(5.2, 7)));

        // Точка снаружи зоны
        $polygon = $this->buildPoligon($points)->build();
        $this->assertEquals(false, $polygon->contains(new Point(4.5, 7)));
    }

    private function buildPoligon(array $points): PolygonBuilder
    {
        $builder = Polygon::builder();

        foreach ($points as $point)
        {
            $builder->addVertex($point);
        }

        return $builder;
    }

    #[Pure] private function pointsProviderForSimplePoligon(): array
    {
        return
        [
             [
                [
                    new Point(1, 5),
                    new Point(2, 8),
                    new Point(5, 4),
                    new Point(5, 9),
                    new Point(6, 4),
                    new Point(5, 2),
                    new Point(3, 1)
                ]
            ],
        ];
    }
}
