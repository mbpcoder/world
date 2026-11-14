<?php

namespace TheCoder\World\Repositories;

class RepositoryFactory
{
    protected function get(string $repository)
    {
        // Repositories hold query state, so every call needs a fresh instance.
        return app()->make($repository);
    }

    public function getContinentRepository(): ContinentRepository
    {
        return $this->get(ContinentRepository::class);
    }

    public function getCountryRepository(): CountryRepository
    {
        return $this->get(CountryRepository::class);
    }


    public function getRegionRepository(): RegionRepository
    {
        return $this->get(RegionRepository::class);
    }

    public function getProvinceRepository(): ProvinceRepository
    {
        return $this->get(ProvinceRepository::class);
    }

    public function getCityRepository(): CityRepository
    {
        return $this->get(CityRepository::class);
    }

}
