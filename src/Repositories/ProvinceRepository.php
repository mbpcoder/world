<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use Thecoder\World\Repositories\Traits\AccessContinent;
use Thecoder\World\Repositories\Traits\AccessCountry;

class ProvinceRepository extends Repository
{
    use MySqlRepository;

    use AccessContinent;
    use AccessCountry;

    protected Location|null $province = null;

    public function __construct()
    {
        $this->query = $this->getNewQuery()->where('type', LocationType::PROVINCE->value);

        parent::__construct();
    }

    public function setProvince(Location|string|int|null $province): self
    {
        if ($province !== null) {
            match (true) {
                is_int($province) => $this->idEqual($province),
                is_string($province) => $this->englishNameEqual($province),
                $province instanceof Location => $this->province = $province,
            };
        }
        return $this;
    }

    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();

        if ($this->province !== null) {
            $cityRepository->provinceIdEqual($this->province->id);
        } elseif ($this->hasWhereConditions()) {
            $this->province = $this->first();
            $cityRepository->provinceIdEqual($this->province->id);
        }
        return $cityRepository;
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
