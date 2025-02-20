<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessCities;
use TheCoder\World\Repositories\Traits\AccessContinent;
use TheCoder\World\Repositories\Traits\AccessProvinces;
use TheCoder\World\Repositories\Traits\AccessRegions;

class CountryRepository extends Repository
{
    use AccessContinent;

    use AccessRegions;
    use AccessProvinces;
    use AccessCities;

    protected Location|null $country = null;

    protected LocationType $locationType = LocationType::COUNTRY;


    public function setCountry(Location|string|int|null $country): self
    {
        if ($country !== null) {
            match (true) {
                is_int($country) => $this->idEqual($country),
                is_string($country) => $this->englishNameEqual($country),
                $country instanceof Location => $this->country = $country,
            };
        }
        return $this;
    }

    protected function setLocation(Location $location): void
    {
        $this->country = $location;
    }

    protected function getLocation(): Location|null
    {
        return $this->country;
    }
}
