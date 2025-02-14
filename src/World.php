<?php

namespace TheCoder\World;

use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;
use TheCoder\World\Repositories\RepositoryFactory;

class World
{

    public function __construct(private RepositoryFactory $repositoryFactory = new RepositoryFactory())
    {
    }

    public function continents(): ContinentRepository
    {
        return $this->repositoryFactory->getContinentRepository();
    }

    public function countries(): CountryRepository
    {
        return $this->repositoryFactory->getCountryRepository();
    }

    public function provinces(): ProvinceRepository
    {
        return $this->repositoryFactory->getProvinceRepository();
    }

    public function states(): ProvinceRepository
    {
        return $this->provinces();
    }

    public function cities(): CityRepository
    {
        return $this->repositoryFactory->getCityRepository();
    }
}
