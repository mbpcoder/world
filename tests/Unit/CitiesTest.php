<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class CitiesTest extends TestCase
{
    public function test_can_get_cities()
    {
        $citiesCount = World::cities()->count();

        $this->assertEquals(152967, $citiesCount);
    }

    public function test_can_get_city_by_name()
    {
        $tehran = World::cities('Tehran')->first();
        $this->assertNotNull($tehran);
        $this->assertEquals('Tehran', $tehran->englishName);
    }

    public function test_can_get_city_by_id()
    {
        $tehranId = World::cities('Tehran')->first()->id;

        $iran = World::cities($tehranId)->first();
        $this->assertEquals('Tehran', $iran->englishName);
    }

    public function test_can_get_continent_by_city()
    {
        $asia = World::cities('Tehran')->continent()->first();
        $this->assertEquals('Asia', $asia->englishName);
    }

    public function test_can_get_country_by_city()
    {
        $iran = World::cities('Tehran')->country()->first();
        $this->assertEquals('Iran', $iran->englishName);
    }

    public function test_can_get_province_by_city()
    {
        $tehran = World::cities('Tehran')->province()->first();
        $this->assertEquals('Tehran', $tehran->englishName);
    }
}
