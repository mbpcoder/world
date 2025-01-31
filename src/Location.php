<?php

namespace TheCoder\World;

use TheCoder\World\Spatial\MultiPolygon;
use TheCoder\World\Spatial\Point;

class Location
{
    public int $id;
    public int|null $continent_id;
    public int|null $country_id;
    public int|null $province_id;
    public string|null $iso_code;
    public LocationType $type;
    public string|null $native_name;
    public string|null $english_name;
    public string|null $timezone;
    public bool $is_capital = false;
    public Point|null $center;
    public MultiPolygon|null $area;
    public int $priority = 0;
    public string $created_at;
    public string $updated_at;
}