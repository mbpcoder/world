<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\ProvinceRepository;

trait AccessProvince
{
    public function province(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();

        $location = $this->getLocation();

        if ($location !== null) {
            $provinceRepository->idEqual($location->provinceId);
        } elseif ($this->hasWhereConditions()) {
            $location = $this->first();
            $this->setLocation($location);
            $provinceRepository->idEqual($location->provinceId);
        }
        return $provinceRepository;
    }
}
