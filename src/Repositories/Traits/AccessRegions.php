<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\LocationType;
use TheCoder\World\Repositories\RegionRepository;

trait AccessRegions
{
    public function regions(): RegionRepository
    {
        $regionRepository = $this->repositoryFactory->getCityRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
        }

        if ($location !== null) {
            match ($this->locationType) {
                LocationType::CONTINENT => $regionRepository->continentIdEqual($location->id),
                LocationType::COUNTRY => $regionRepository->countryIdEqual($location->id),
            };
        }
        return $regionRepository;
    }
}
