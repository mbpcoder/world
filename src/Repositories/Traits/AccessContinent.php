<?php

namespace TheCoder\World\Repositories\Traits;


use TheCoder\World\Repositories\ContinentRepository;

trait AccessContinent
{
    public function continent(): ContinentRepository
    {
        $continentRepository = $this->repositoryFactory->getContinentRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $continentRepository->byId($location->continentId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $continentRepository->byId($location->continentId);
        }
        return $continentRepository;
    }
}
