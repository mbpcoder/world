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
        $this->assertEquals(3, $asia->id);
    }

    public function test_can_get_continent_by_id()
    {
        $asia = World::continents(3)->first();
        $this->assertEquals('Asia', $asia->englishName);
    }
}
