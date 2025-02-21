<?php

namespace TheCoder\World\Facades;

use Illuminate\Support\Facades\Facade;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;
use TheCoder\World\Repositories\RegionRepository;

/**
 * @method static ContinentRepository continents(int|string|null $continent = null)
 * @method static CountryRepository countries(int|string|null $country = null)
 * @method static ProvinceRepository provinces(int|string|null $province = null)
 * @method static RegionRepository regions(int|string|null $region = null)
 * @method static CityRepository cities(int|string|null $city = null)
 * @method static void clearCache()
 * @method static get()
 * @method static first()
 * @method static count()
 * @method static byId(int $id)
 * @method static byIds(array $ids)
 * @method static byEnglishName(string $englishName)
 * @method static byNativeName(string $nativeName)
 * @method static byContinentId(int $continentId)
 * @method static byCountryId(int $countryId)
 * @method static byRegionId(int $regionId)
 * @method static byProvinceId(int $provinceId)
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
