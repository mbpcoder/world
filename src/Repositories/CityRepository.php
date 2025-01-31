<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;

class CityRepository
{
    public function province(): Location
    {
        $province = new Location();
        return $province;
    }

    public function country()
    {
        $country = new Location();
        return $country;
    }

    public function continent()
    {
        $continent = new Location();
        return $continent;
    }
}