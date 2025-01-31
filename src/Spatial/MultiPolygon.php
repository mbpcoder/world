<?php

namespace TheCoder\World\Spatial;

use Illuminate\Support\Facades\DB;

class MultiPolygon
{
    /** @var Polygon[] $polygons */
    public array $polygons;

    public function __construct($polygons = [])
    {
        $this->polygons = $polygons;
    }

    public function parse(string $polygons): static
    {
        $multiPolygon = str_replace(['multipolygon(((', ')))', ')),(('], ['(', ')', ')|('], strtolower($polygons));
        $polygons = explode('|', $multiPolygon);
        foreach ($polygons as $key1 => $polygon) {
            self::addPolygon((new Polygon())->parse($polygon));
        }
        return $this;
    }

    public function toArray(): array
    {
        $multiPolygon = [];
        foreach ($this->polygons as $key1 => $polygon) {
            /** @var Polygon $polygon */
            foreach ($polygon->getPoints() as $key2 => $point) {
                $multiPolygon[$key1][$key2]['lat'] = $point->getLatitude();
                $multiPolygon[$key1][$key2]['lng'] = $point->getLongitude();
            }
        }
        return $multiPolygon;
    }

    /**
     * @param Polygon $polygon
     */
    public function addPolygon(Polygon $polygon): void
    {
        $this->polygons[] = $polygon;
    }

    public function __toString(): string
    {
        return implode(',', array_map(function (Polygon $polygon) {
            return sprintf('(%s)', (string)$polygon);
        }, $this->polygons));
    }

    public function toWKT()
    {
        return sprintf('MULTIPOLYGON(%s)', (string)$this);
    }

    public function getSqlFromText()
    {
        return DB::raw(sprintf('ST_GeomFromText("%s")', $this->toWKT()));
    }
}
