<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\RegionRepository;

trait AccessRegion
{
    public function region(): RegionRepository
    {
        $regionRepository = $this->repositoryFactory->getRegionRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
            if ($location !== null) {
                $this->setLocation($location);
            }
        }

        $regionRepository->byId($location?->regionId ?? 0);

        return $regionRepository;
    }
}
