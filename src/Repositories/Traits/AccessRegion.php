<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\RegionRepository;

trait AccessRegion
{
    public function region(): RegionRepository
    {
        $regionRepository = $this->repositoryFactory->getContinentRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $regionRepository->byId($location->continentId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $regionRepository->byId($location->continentId);
        }
        return $regionRepository;
    }
}
