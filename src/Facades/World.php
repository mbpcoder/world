<?php

namespace TheCoder\World\Facades;

use Illuminate\Support\Facades\Facade;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;

/**
 * @method static ContinentRepository continents()
 * @method static CountryRepository countries()
 * @method static ProvinceRepository provinces()
 * @method static CityRepository cities()
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
