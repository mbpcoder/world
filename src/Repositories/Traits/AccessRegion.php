<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\RegionRepository;

trait AccessRegion
{
    public function region(): RegionRepository
    {
        $regionRepository = $this->repositoryFactory->getRegionRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $regionRepository->byId($location->regionId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $regionRepository->byId($location->regionId);
        }
        return $regionRepository;
    }
}
