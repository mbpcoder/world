<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessCities;
use TheCoder\World\Repositories\Traits\AccessContinent;
use TheCoder\World\Repositories\Traits\AccessCountry;
use TheCoder\World\Repositories\Traits\AccessRegion;

class ProvinceRepository extends Repository
{
    use AccessContinent;
    use AccessCountry;
    use AccessRegion;

    use AccessCities;

    protected Location|null $province = null;
    protected LocationType $locationType = LocationType::PROVINCE;

    public function setProvince(Location|string|int|null $province): self
    {
        if ($province !== null) {
            match (true) {
                is_int($province) => $this->byId($province),
                is_string($province) => $this->byEnglishName($province),
                $province instanceof Location => $this->province = $province,
            };
        }
        return $this;
    }

    protected function setLocation(Location $location): void
    {
        $this->province = $location;
    }

    protected function getLocation(): Location|null
    {
        return $this->province;
    }
}
