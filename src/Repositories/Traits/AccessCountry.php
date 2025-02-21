<?php

namespace TheCoder\World\Repositories\Traits;


use TheCoder\World\Repositories\CountryRepository;

trait AccessCountry
{
    public function country(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $countryRepository->byId($location->countryId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $countryRepository->byId($location->countryId);
        }
        return $countryRepository;
    }
}
