<?php

namespace Tests\Location\Polygon;

use App\Modules\Location\Builders\PolygonBuilder;
use App\Modules\Location\Polygon\Point;
use App\Modules\Location\Polygon\Polygon;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;

class WithHolePolygonServiceTest extends TestCase
{
    /**
     * @dataProvider pointsProviderForWithHoles
     */
    public function testPolygonWithHoles(array $zoneFirst, array $zoneSeconds, array $zoneThird) {

        $zones = [$zoneFirst, $zoneSeconds, $zoneThird];

        //Точка внутри зоны
       $this->assertEquals(true, $this->getPoligonWithHole($zones)->contains(new Point(6, 5)));

        //Точка снаружи зоны
        $this->assertEquals(false, $this->getPoligonWithHole($zones)->contains(new Point(4, 3)));

        //Точка снаружи зоны
        $this->assertEquals(false, $this->getPoligonWithHole($zones)->contains(new Point(6.5, 5.8)));
    }

    private function getPoligonWithHole(array $zones): Polygon
    {
        $builder = Polygon::builder();

        foreach ($zones as $zone)
        {
            $builder = $this->buildPoligon($zone, $builder)->close();
        }

        return $builder->build();
    }

    private function buildPoligon(array $points, PolygonBuilder $builder = null): PolygonBuilder
    {
        $builder = $builder ?? Polygon::builder();

        foreach ($points as $point)
        {
            $builder->addVertex($point);
        }

        return $builder;
    }

    #[Pure] private function pointsProviderForWithHoles(): array
    {
        return [
            [
                [
                    new Point(1, 2),
                    new Point(1, 6),
                    new Point(8, 7),
                    new Point(8, 4),
                ],
                [
                    new Point(2, 4),
                    new Point(5, 6),
                    new Point(5, 3),
                ],
                [
                    new Point(6, 6),
                    new Point(8, 6),
                    new Point(7, 3),
                ],
            ],
        ];

    }
}
