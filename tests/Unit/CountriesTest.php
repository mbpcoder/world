<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class CountriesTest extends TestCase
{
    public function test_can_get_countries()
    {
        $countries = World::countries()->get();

        $this->assertIsArray($countries->toArray());
        $this->assertNotEmpty($countries);
        $this->assertEquals(250, $countries->count());
    }

    public function test_can_get_country_by_name()
    {
        $iran = World::countries('Iran')->first();
        $this->assertEquals(110, $iran->id);
    }

    public function test_can_get_country_by_id()
    {
        $iran = World::countries(110)->first();
        $this->assertEquals('Iran', $iran->englishName);
    }

    public function test_can_get_continent_by_country()
    {
        $asia = World::countries('Iran')->continent()->first();
        $this->assertEquals('Asia', $asia->englishName);
    }

    public function test_can_get_provinces_by_country()
    {
        $provinces = World::countries('Iran')->provinces()->get();
        $this->assertEquals(31, $provinces->count());
    }

    public function test_can_get_cities_by_country()
    {
        $cities = World::countries('Iran')->cities()->get();
        $this->assertEquals(1854, $cities->count());
    }
}
