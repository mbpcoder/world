<?php

namespace TheCoder\World\Facades;

use Illuminate\Support\Facades\Facade;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;

/**
 * @method static ContinentRepository continents(int|string|null $continent = null)
 * @method static CountryRepository countries(int|string|null $country = null)
 * @method static ProvinceRepository provinces(int|string|null $province = null)
 * @method static CityRepository cities(int|string|null $city = null)
 *
 * @see \TheCoder\World\World
 */
class World extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TheCoder\World\World::class;
    }
}
