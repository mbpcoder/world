<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\LocationType;
use TheCoder\World\Repositories\ProvinceRepository;

trait AccessProvinces
{
    public function provinces(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
        }

        if ($location !== null) {
            match ($this->locationType) {
                LocationType::CONTINENT => $provinceRepository->byContinentId($location->id),
                LocationType::COUNTRY => $provinceRepository->byCountryId($location->id),
                LocationType::REGION => $provinceRepository->byRegionId($location->id)
            };
        }
        return $provinceRepository;
    }
}
