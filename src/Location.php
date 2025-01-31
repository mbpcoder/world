<?php

namespace TheCoder\World;

use TheCoder\World\Spatial\MultiPolygon;
use TheCoder\World\Spatial\Point;

class Location
{
    public int $id;
    public int|null $continentId;
    public int|null $countryId;
    public int|null $provinceId;
    public string|null $isoCode;
    public LocationType $type;
    public string|null $nativeName;
    public string|null $englishName;
    public string|null $timezone;
    public bool $isCapital = false;
    public Point|null $center;
    public MultiPolygon|null $area;
    public int $priority = 0;
}