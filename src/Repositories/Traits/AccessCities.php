<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Location;
use TheCoder\World\LocationType;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ProvinceRepository;

trait AccessCities
{
    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
        }

        if ($location !== null) {
            match ($this->locationType) {
                LocationType::CONTINENT => $cityRepository->continentIdEqual($location->id),
                LocationType::COUNTRY => $cityRepository->countryIdEqual($location->id),
                LocationType::REGION => $cityRepository->regionIdEqual($location->id),
                LocationType::PROVINCE => $cityRepository->provinceIdEqual($location->id),
            };
        }
        return $cityRepository;
    }
}
