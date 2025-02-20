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
                LocationType::CONTINENT => $provinceRepository->continentIdEqual($location->id),
                LocationType::COUNTRY => $provinceRepository->countryIdEqual($location->id),
                LocationType::REGION => $provinceRepository->regionIdEqual($location->id)
            };
        }
        return $provinceRepository;
    }
}
