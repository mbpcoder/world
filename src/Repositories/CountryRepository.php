<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\Traits\AccessContinent;

class CountryRepository extends Repository
{
    use LocationRepository;

    use AccessContinent;

    protected Location|null $country = null;

    public function __construct()
    {
        $this->query = $this->getNewQuery()->where('type', LocationType::COUNTRY->value);

        parent::__construct();
    }

    public function provinces(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();

        if ($this->country !== null) {
            $provinceRepository->countryIdEqual($this->country->id);
        } elseif ($this->hasWhereConditions()) {
            $this->country = $this->first();
            $provinceRepository->countryIdEqual($this->country->id);
        }
        return $provinceRepository;
    }

    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();

        if ($this->country !== null) {
            $cityRepository->countryIdEqual($this->country->id);
        } elseif ($this->hasWhereConditions()) {
            $this->country = $this->first();
            $cityRepository->countryIdEqual($this->country->id);
        }
        return $cityRepository;
    }

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
