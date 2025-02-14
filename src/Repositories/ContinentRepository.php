<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationType;

class ContinentRepository extends Repository
{
    use MySqlRepository;

    protected Location|null $continent = null;

    public function __construct()
    {
        $this->query = $this->getNewQuery()->where('type', LocationType::CONTINENT->value);

        parent::__construct();
    }

    public function setContinent(Location|string|int|null $continent): self
    {
        if ($continent !== null) {
            match (true) {
                is_int($continent) => $this->idEqual($continent),
                is_string($continent) => $this->englishNameEqual($continent),
                $continent instanceof Location => $this->continent = $continent,
            };
        }
        return $this;
    }

    public function countries(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();

        if ($this->continent !== null) {
            $countryRepository->continentIdEqual($this->continent->id);
        } elseif ($this->hasWhereConditions()) {
            $this->continent = $this->first();
            $countryRepository->continentIdEqual($this->continent->id);
        }
        return $countryRepository;
    }

    public function provinces(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();

        if ($this->continent !== null) {
            $provinceRepository->continentIdEqual($this->continent->id);
        } elseif ($this->hasWhereConditions()) {
            $this->continent = $this->first();
            $provinceRepository->continentIdEqual($this->continent->id);
        }
        return $provinceRepository;
    }

    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();

        if ($this->continent !== null) {
            $cityRepository->continentIdEqual($this->continent->id);
        } elseif ($this->hasWhereConditions()) {
            $this->continent = $this->first();
            $cityRepository->continentIdEqual($this->continent->id);
        }
        return $cityRepository;
    }
}
