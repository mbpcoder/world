<?php

namespace TheCoder\World\Tests\Unit;

use TheCoder\World\Location;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;
use TheCoder\World\Tests\TestCase;

class LocationRepositoryTest extends TestCase
{
    private function countries(): CountryRepository
    {
        return app(CountryRepository::class);
    }

    private function provinces(): ProvinceRepository
    {
        return app(ProvinceRepository::class);
    }

    private function cities(): CityRepository
    {
        return app(CityRepository::class);
    }

    private function iran(): Location
    {
        return $this->countries()->byEnglishName('Iran')->first();
    }

    public function test_get_returns_collection_of_locations()
    {
        $countries = $this->countries()->byEnglishNames(['Iran', 'Italy'])->get();

        $this->assertCount(2, $countries);
        $this->assertContainsOnlyInstancesOf(Location::class, $countries);
    }

    public function test_get_returns_empty_collection_when_nothing_matches()
    {
        $countries = $this->countries()->byEnglishName('Atlantis')->get();

        $this->assertTrue($countries->isEmpty());
    }

    public function test_first_returns_null_when_nothing_matches()
    {
        $this->assertNull($this->countries()->byEnglishName('Atlantis')->first());
    }

    public function test_count_returns_number_of_matches()
    {
        $this->assertSame(250, $this->countries()->count());
        $this->assertSame(1, $this->countries()->byEnglishName('Iran')->count());
        $this->assertSame(0, $this->countries()->byEnglishName('Atlantis')->count());
    }

    public function test_by_id()
    {
        $iran = $this->iran();

        $found = $this->countries()->byId($iran->id)->first();

        $this->assertEquals($iran->id, $found->id);
        $this->assertEquals('Iran', $found->englishName);
    }

    public function test_by_ids()
    {
        $ids = $this->countries()->byEnglishNames(['Iran', 'Italy'])->get()->pluck('id')->all();

        $found = $this->countries()->byIds($ids)->get();

        $this->assertEqualsCanonicalizing($ids, $found->pluck('id')->all());
    }

    public function test_by_english_name()
    {
        $found = $this->countries()->byEnglishName('Italy')->first();

        $this->assertEquals('Italy', $found->englishName);
    }

    public function test_by_english_names()
    {
        $found = $this->countries()->byEnglishNames(['Iran', 'Italy'])->get();

        $this->assertEqualsCanonicalizing(['Iran', 'Italy'], $found->pluck('englishName')->all());
    }

    public function test_by_native_name()
    {
        $iran = $this->iran();
        $this->assertNotNull($iran->nativeName);

        $found = $this->countries()->byNativeName($iran->nativeName)->first();

        $this->assertEquals($iran->id, $found->id);
    }

    public function test_by_native_names()
    {
        $locations = $this->countries()->byEnglishNames(['Iran', 'Italy'])->get();
        $nativeNames = $locations->pluck('nativeName')->all();

        $found = $this->countries()->byNativeNames($nativeNames)->get();

        $this->assertEqualsCanonicalizing($locations->pluck('id')->all(), $found->pluck('id')->all());
    }

    public function test_by_continent_id()
    {
        $asia = app(\TheCoder\World\Repositories\ContinentRepository::class)->byEnglishName('Asia')->first();

        $countries = $this->countries()->byContinentId($asia->id)->get();

        $this->assertNotEmpty($countries);
        $this->assertTrue($countries->every(fn(Location $country) => $country->continentId === $asia->id));
    }

    public function test_by_country_id()
    {
        $iran = $this->iran();

        $provinces = $this->provinces()->byCountryId($iran->id)->get();

        $this->assertCount(31, $provinces);
        $this->assertTrue($provinces->every(fn(Location $province) => $province->countryId === $iran->id));
    }

    public function test_by_province_id()
    {
        $tehran = $this->provinces()->byEnglishName('Tehran')->first();
        $this->assertNotNull($tehran);

        $cities = $this->cities()->byProvinceId($tehran->id)->get();

        $this->assertNotEmpty($cities);
        $this->assertTrue($cities->every(fn(Location $city) => $city->provinceId === $tehran->id));
    }

    public function test_by_region_id()
    {
        $region = app(\TheCoder\World\Repositories\RegionRepository::class)->first();
        $this->assertNotNull($region);

        $provinces = $this->provinces()->byRegionId($region->id)->get();

        $this->assertNotEmpty($provinces);
        $this->assertTrue($provinces->every(fn(Location $province) => $province->regionId === $region->id));
    }
}
