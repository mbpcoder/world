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

    public function continents(int|string|null $continent = null): ContinentRepository
    {
        $continentRepository = $this->repositoryFactory->getContinentRepository();
        $continentRepository->setContinent($continent);
        return $continentRepository;
    }

    public function countries(int|string|null $country = null): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();
        $countryRepository->setCountry($country);
        return $countryRepository;
    }

    public function provinces(int|string|null $province = null): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();
        $provinceRepository->setProvince($province);
        return $provinceRepository;
    }

    public function states(): ProvinceRepository
    {
        return $this->provinces();
    }

    public function cities(int|string|null $city = null): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();
        $cityRepository->setCity($city);
        return $cityRepository;
    }
}
