<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;

class ProvinceRepository
{
    public function country()
    {
        $country = new Location();
        return $country;
    }

    public function continent(): Location
    {
        $province = new Location();
        return $province;
    }

    /**
     * @return array<Location>
     */
    public function cities(): array
    {
        return [];
    }

    public function neighbors(): array
    {
        return [];
    }
}