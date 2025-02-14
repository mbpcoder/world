<?php

namespace Thecoder\World\Repositories\Traits;


use TheCoder\World\Repositories\CountryRepository;

trait AccessCountry
{
    public function country(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $countryRepository->idEqual($location->countryId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $countryRepository->idEqual($location->countryId);
        }
        return $countryRepository;
    }
}
