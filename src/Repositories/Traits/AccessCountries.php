<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\LocationType;
use TheCoder\World\Repositories\CountryRepository;

trait AccessCountries
{
    public function countries(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
        }

        if ($location !== null) {
            $countryRepository->byContinentId($location->id);
        }
        return $countryRepository;
    }
}
