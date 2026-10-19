<?php

namespace TheCoder\World\Tests\Unit;

use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;
use TheCoder\World\Tests\TestCase;

class RepositorySettersTest extends TestCase
{
    public function test_set_country_with_string_int_and_location()
    {
        $iran = app(CountryRepository::class)->setCountry('Iran')->first();
        $this->assertEquals('Iran', $iran->englishName);

        $byId = app(CountryRepository::class)->setCountry($iran->id)->first();
        $this->assertEquals($iran->id, $byId->id);

        $this->assertCount(31, app(CountryRepository::class)->setCountry($iran)->provinces()->get());
    }

    public function test_set_country_with_null_does_not_filter()
    {
        $this->assertEquals(250, app(CountryRepository::class)->setCountry(null)->count());
    }

    public function test_set_continent_with_string_int_and_location()
    {
        $asia = app(ContinentRepository::class)->setContinent('Asia')->first();
        $this->assertEquals('Asia', $asia->englishName);

        $byId = app(ContinentRepository::class)->setContinent($asia->id)->first();
        $this->assertEquals($asia->id, $byId->id);

        $countries = app(ContinentRepository::class)->setContinent($asia)->countries()->get();
        $this->assertNotEmpty($countries);
        $this->assertTrue($countries->every(fn($country) => $country->continentId === $asia->id));
    }

    public function test_set_continent_with_null_does_not_filter()
    {
        $this->assertGreaterThan(1, app(ContinentRepository::class)->setContinent(null)->count());
    }

    public function test_set_province_with_string_int_and_location()
    {
        $tehran = app(ProvinceRepository::class)->setProvince('Tehran')->first();
        $this->assertEquals('Tehran', $tehran->englishName);

        $byId = app(ProvinceRepository::class)->setProvince($tehran->id)->first();
        $this->assertEquals($tehran->id, $byId->id);

        $cities = app(ProvinceRepository::class)->setProvince($tehran)->cities()->get();
        $this->assertNotEmpty($cities);
    }

    public function test_set_province_with_null_does_not_filter()
    {
        $this->assertGreaterThan(1, app(ProvinceRepository::class)->setProvince(null)->count());
    }

    public function test_set_city_with_string_and_int()
    {
        $city = app(CityRepository::class)->setCity('Tehran')->first();
        $this->assertNotNull($city);
        $this->assertEquals('Tehran', $city->englishName);

        $byId = app(CityRepository::class)->setCity($city->id)->first();
        $this->assertEquals($city->id, $byId->id);
    }

    public function test_set_city_with_null_does_not_filter()
    {
        $this->assertGreaterThan(1, app(CityRepository::class)->setCity(null)->count());
    }
}
