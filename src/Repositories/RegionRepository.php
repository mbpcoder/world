<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessCities;
use TheCoder\World\Repositories\Traits\AccessContinent;
use TheCoder\World\Repositories\Traits\AccessCountry;
use TheCoder\World\Repositories\Traits\AccessProvinces;

class RegionRepository extends Repository
{
    use AccessContinent;
    use AccessCountry;

    use AccessCities;
    use AccessProvinces;

    protected Location|null $region = null;
    protected LocationType $locationType = LocationType::REGION;

    public function setRegion(Location|string|int|null $region): self
    {
        if ($region !== null) {
            match (true) {
                is_int($region) => $this->byId($region),
                is_string($region) => $this->byEnglishName($region),
                $region instanceof Location => $this->region = $region,
            };
        }
        return $this;
    }

    protected function setLocation(Location $location): void
    {
        $this->region = $location;
    }

    protected function getLocation(): Location|null
    {
        return $this->region;
    }
}
