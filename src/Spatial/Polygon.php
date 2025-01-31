<?php

namespace TheCoder\World\Spatial;

use Illuminate\Support\Facades\DB;

class Polygon
{
    /** @var Point[] $points */
    public array $points;

    public function __construct($points = [])
    {
        $this->points = $points;
    }

    public function parse(string $polygon): static
    {
        $polygon = str_replace(['polygon((', '))', '),('], ['(', ')', ')|('], strtolower($polygon));
        $lineStrings = explode('|', $polygon);
        foreach ($lineStrings as $lineString) {
            $lineString = str_replace(['(', ')'], ['', ''], $lineString);
            $points = explode(',', $lineString);
            foreach ($points as $key2 => $_points) {
                self::addPoint((new Point())->parse($_points));
            }
        }
        return $this;
    }

    /**
     * @param Point $point
     */
    public function addPoint(Point $point): void
    {
        $this->points[] = $point;
    }

    /**
     * @return Point[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $string = '';
        foreach ($this->points as $index => $point) {
            $string .= ($index > 0 ? ',' : '') .  $point->toPair();
        }
        $string .= ',' . $this->points[0]->toPair();
        return '(' . $string . ')';
    }

    public function toWKT()
    {
        return sprintf('POLYGON(%s)', (string) $this);
    }

    public function getSqlFromText()
    {
        return DB::raw(sprintf('ST_GeomFromText(%s)', $this->toWKT()));
    }
}
