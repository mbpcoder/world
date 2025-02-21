<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessCities;
use TheCoder\World\Repositories\Traits\AccessCountries;
use TheCoder\World\Repositories\Traits\AccessProvinces;
use TheCoder\World\Repositories\Traits\AccessRegions;

class ContinentRepository extends Repository
{
    use AccessCountries;
    use AccessRegions;
    use AccessProvinces;
    use AccessCities;

    protected Location|null $continent = null;
    protected LocationType $locationType = LocationType::CONTINENT;

    public function setContinent(Location|string|int|null $continent): self
    {
        if ($continent !== null) {
            match (true) {
                is_int($continent) => $this->byId($continent),
                is_string($continent) => $this->byEnglishName($continent),
                $continent instanceof Location => $this->continent = $continent,
            };
        }
        return $this;
    }
}
