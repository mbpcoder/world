<?php

namespace TheCoder\World\Tests\Unit;

use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class ContinentsTest extends TestCase
{
    public function test_can_get_continents()
    {
        $continents = World::continents()->get();

        $this->assertIsArray($continents->toArray());
        $this->assertNotEmpty($continents);
        $this->assertEquals(7, $continents->count());
    }

    public function test_can_get_continent_by_name()
    {
        $asia = World::continents('Asia')->first();
        $this->assertNotNull($asia);
        $this->assertEquals('Asia', $asia->englishName);
    }

    public function test_can_get_continent_by_id()
    {
        $asiaId = World::continents('Asia')->first()->id;

        $asia = World::continents($asiaId)->first();
        $this->assertEquals('Asia', $asia->englishName);
    }
}
