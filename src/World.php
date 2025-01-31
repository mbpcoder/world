<?php

namespace TheCoder\World;

use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;

class World
{
    public function __construct(
        private ContinentRepository $continentRepository = new ContinentRepository(),
        private CountryRepository   $countryRepository = new CountryRepository(),
        private ProvinceRepository  $provinceRepository = new ProvinceRepository(),
        private CityRepository      $cityRepository = new CityRepository()
    )
    {
    }

    public function continents(): ContinentRepository
    {
        return $this->continentRepository;
    }

    public function countries(): CountryRepository
    {
        return $this->countryRepository;
    }

    public function provinces(): ProvinceRepository
    {
        return $this->provinceRepository;
    }

    public function states(): ProvinceRepository
    {
        return $this->provinces();
    }

    public function cities(): CityRepository
    {
        return $this->cityRepository;
    }
}