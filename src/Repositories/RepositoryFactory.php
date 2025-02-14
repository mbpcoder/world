<?php

namespace TheCoder\World\Repositories;

class RepositoryFactory
{
    protected $repositories = [];

    protected function get(string $repository)
    {
        if (!isset($this->repositories[$repository])) {
            $this->repositories[$repository] = app($repository);
        }
        return $this->repositories[$repository];
    }

    public function getContinentRepository(): ContinentRepository
    {
        return $this->get(ContinentRepository::class);
    }

    public function getCountryRepository(): CountryRepository
    {
        return $this->get(CountryRepository::class);
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
