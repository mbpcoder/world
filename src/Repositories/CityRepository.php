<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessContinent;
use TheCoder\World\Repositories\Traits\AccessCountry;
use TheCoder\World\Repositories\Traits\AccessProvince;

class CityRepository extends Repository
{
    use LocationRepository;
    use AccessContinent;
    use AccessCountry;
    use AccessProvince;

    protected Location|null $city = null;

    public function __construct()
    {
        $this->query = $this->getNewQuery()->where('type', LocationType::CITY->value);

        parent::__construct();
    }

    public function setCity(Location|string|int|null $city): self
    {
        if ($city !== null) {
            match (true) {
                is_int($city) => $this->idEqual($city),
                is_string($city) => $this->englishNameEqual($city),
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
