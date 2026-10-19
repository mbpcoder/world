<?php

namespace TheCoder\World\Repositories\Traits;

use TheCoder\World\Repositories\CityRepository;

trait AccessProvinceCapitals
{
    public function provinceCapitals(): CityRepository
    {
        return $this->cities()->provinceCapitals();
    }
}
