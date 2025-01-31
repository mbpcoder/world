<?php

namespace TheCoder\World\Spatial;

use Illuminate\Support\Facades\DB;

class Point
{
    public float $latitude;
    public float $longitude;

    /**
     * Point constructor.
     * @param $latitude
     * @param $longitude
     */
    public function __construct($latitude = null, $longitude = null)
    {
        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
    }

    public function parse($point)
    {
        $point = str_replace(['point(', ')'], '', strtolower($point));
        list($latitude, $longitude) = explode(' ', $point);
        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
        return $this;
    }

    public function parseBinary($point)
    {
        $coordinates = unpack('x/x/x/x/corder/Ltype/dlat/dlon', (string)$point);
        $latitude = isset($coordinates['lat']) ? $coordinates['lat'] : null;
        $longitude = isset($coordinates['lon']) ? $coordinates['lon'] : null;
        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function isEmpty()
    {
        return (empty($this->latitude) || empty($this->longitude));
    }

    public function getSqlFromText()
    {
        return $this->isEmpty() ? null : DB::raw(sprintf('ST_GeomFromText("%s")', $this->toWKT()));
    }

    public function __toString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->toPair();
    }

    public function toPair(): string
    {
        return $this->latitude . ' ' . $this->longitude;
    }

    public function toWKT()
    {
        return sprintf('POINT(%s)', (string)$this);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
