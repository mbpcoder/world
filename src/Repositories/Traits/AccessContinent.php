<?php

namespace Thecoder\World\Repositories\Traits;


use TheCoder\World\Repositories\ContinentRepository;

trait AccessContinent
{
    public function continent(): ContinentRepository
    {
        $continentRepository = $this->repositoryFactory->getContinentRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $continentRepository->idEqual($location->continentId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $continentRepository->idEqual($location->continentId);
        }
        return $continentRepository;
    }
}
