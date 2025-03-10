<?php

namespace TheCoder\World\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use TheCoder\World\Location;
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
 * @method static Collection get()
 * @method static Location|null first()
 * @method static int count()
 * @method static self byId(int $id)
 * @method static self byContinentId(int $continentId)
 * @method static self byCountryId(int $countryId)
 * @method static self byRegionId(int $regionId)
 * @method static self byProvinceId(int $provinceId)
 * @method static self byIds(array $ids)
 * @method static self byEnglishName(string $englishName)
 * @method static self byEnglishNames(array $englishNames)
 * @method static self byNativeName(string $nativeName)
 * @method static self byNativeNames(array $nativeNames)
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
