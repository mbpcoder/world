<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessContinent;
use TheCoder\World\Repositories\Traits\AccessCountry;
use TheCoder\World\Repositories\Traits\AccessProvince;
use TheCoder\World\Repositories\Traits\AccessRegion;

class CityRepository extends Repository
{
    use AccessContinent;
    use AccessCountry;
    use AccessRegion;
    use AccessProvince;

    protected Location|null $city = null;
    protected LocationType $locationType = LocationType::CITY;

    public function setCity(Location|string|int|null $city): self
    {
        if ($city !== null) {
            match (true) {
                is_int($city) => $this->byId($city),
                is_string($city) => $this->byEnglishName($city),
                $city instanceof Location => $this->city = $city,
            };
        }
        return $this;
    }

    protected function setLocation(Location $location): void
    {
        $this->city = $location;
    }

    protected function getLocation(): Location|null
    {
        return $this->city;
    }
}
