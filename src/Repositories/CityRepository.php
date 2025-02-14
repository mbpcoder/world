<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;
use Illuminate\Support\Facades\DB;
use Thecoder\World\Repositories\Traits\AccessContinent;
use Thecoder\World\Repositories\Traits\AccessCountry;
use Thecoder\World\Repositories\Traits\AccessProvince;

class CityRepository extends Repository
{
    use MySqlRepository;
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
