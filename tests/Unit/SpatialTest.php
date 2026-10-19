<?php

namespace TheCoder\World\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TheCoder\World\Spatial\MultiPolygon;
use TheCoder\World\Spatial\Point;
use TheCoder\World\Spatial\Polygon;

class SpatialTest extends TestCase
{
    public function test_point_parses_wkt()
    {
        $point = (new Point())->parse('POINT(35.5 51.25)');

        $this->assertSame(35.5, $point->getLatitude());
        $this->assertSame(51.25, $point->getLongitude());
    }

    public function test_point_parses_binary()
    {
        $binary = pack('x4') . pack('c', 1) . pack('L', 1) . pack('d', 35.5) . pack('d', 51.25);

        $point = (new Point())->parseBinary($binary);

        $this->assertSame(35.5, $point->getLatitude());
        $this->assertSame(51.25, $point->getLongitude());
    }

    public function test_point_conversions()
    {
        $point = new Point(35.5, 51.25);

        $this->assertSame('35.5 51.25', $point->toPair());
        $this->assertSame('35.5 51.25', (string)$point);
        $this->assertSame('POINT(35.5 51.25)', $point->toWKT());
        $this->assertSame(['latitude' => 35.5, 'longitude' => 51.25], $point->toArray());
        $this->assertSame(['latitude' => 35.5, 'longitude' => 51.25], $point->jsonSerialize());
        $this->assertSame('{"latitude":35.5,"longitude":51.25}', $point->toJson());
    }

    public function test_empty_point()
    {
        $point = new Point();

        $this->assertTrue($point->isEmpty());
        $this->assertSame('', (string)$point);
        $this->assertNull($point->getSqlFromText());
        $this->assertFalse((new Point(1, 2))->isEmpty());
    }

    public function test_polygon_parses_wkt()
    {
        $polygon = (new Polygon())->parse('POLYGON((0 0,0 1,1 1,0 0))');

        $this->assertCount(4, $polygon->getPoints());
        $this->assertSame(1.0, $polygon->getPoints()[2]->getLatitude());
    }

    public function test_polygon_add_point()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Point(1, 2));

        $this->assertCount(1, $polygon->getPoints());
    }

    public function test_polygon_to_string_closes_the_ring()
    {
        $polygon = new Polygon([new Point(0, 0), new Point(0, 1), new Point(1, 1)]);

        $this->assertSame('(0 0,0 1,1 1,0 0)', (string)$polygon);
        $this->assertSame('POLYGON((0 0,0 1,1 1,0 0))', $polygon->toWKT());
    }

    public function test_multi_polygon_parses_wkt()
    {
        $multiPolygon = (new MultiPolygon())->parse('MULTIPOLYGON(((0 0,0 1,1 1,0 0)),((2 2,2 3,3 3,2 2)))');

        $this->assertCount(2, $multiPolygon->polygons);
        $this->assertCount(4, $multiPolygon->polygons[1]->getPoints());
        $this->assertSame(2.0, $multiPolygon->polygons[1]->getPoints()[0]->getLatitude());
    }

    public function test_multi_polygon_to_array()
    {
        $multiPolygon = new MultiPolygon([new Polygon([new Point(1, 2), new Point(3, 4)])]);

        $this->assertSame([
            [
                ['lat' => 1.0, 'lng' => 2.0],
                ['lat' => 3.0, 'lng' => 4.0],
            ],
        ], $multiPolygon->toArray());
    }

    public function test_multi_polygon_to_wkt()
    {
        $multiPolygon = new MultiPolygon();
        $multiPolygon->addPolygon(new Polygon([new Point(0, 0), new Point(0, 1), new Point(1, 1)]));
        $multiPolygon->addPolygon(new Polygon([new Point(2, 2), new Point(2, 3), new Point(3, 3)]));

        $this->assertSame('MULTIPOLYGON(((0 0,0 1,1 1,0 0)),((2 2,2 3,3 3,2 2)))', $multiPolygon->toWKT());
    }
}
