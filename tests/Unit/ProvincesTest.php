<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class ProvincesTest extends TestCase
{
    public function test_can_get_provinces()
    {
        $provinces = World::provinces()->get();

        $this->assertIsArray($provinces->toArray());
        $this->assertNotEmpty($provinces);
        $this->assertEquals(3577, $provinces->count());
    }

    public function test_can_get_province_by_name()
    {
        $tehran = World::provinces('Tehran')->first();
        $this->assertEquals(1483, $tehran->id);
    }

    public function test_can_get_province_by_id()
    {
        $iran = World::provinces(1483)->first();
        $this->assertEquals('Tehran', $iran->englishName);
    }

    public function test_can_get_continent_by_province()
    {
        $asia = World::provinces('Tehran')->continent()->first();
        $this->assertEquals('Asia', $asia->englishName);
    }

    public function test_can_get_country_by_province()
    {
        $iran = World::provinces('Tehran')->country()->first();
        $this->assertEquals('Iran', $iran->englishName);
    }

    public function test_can_get_cities_by_province()
    {
        $cities = World::provinces('Tehran')->cities()->get();
        $this->assertEquals(51, $cities->count());
    }
}
