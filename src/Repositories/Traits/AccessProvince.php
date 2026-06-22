<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\ProvinceRepository;

trait AccessProvince
{
    public function province(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();

        $location = $this->getLocation();

        if ($location === null && $this->hasWhereConditions()) {
            $location = $this->first();
            if ($location !== null) {
                $this->setLocation($location);
            }
        }

        $provinceRepository->byId($location?->provinceId ?? 0);

        return $provinceRepository;
    }
}
