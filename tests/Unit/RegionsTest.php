<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class RegionsTest extends TestCase
{
    public function test_can_get_regions()
    {
        $regions = World::regions()->get();

        $this->assertIsArray($regions->toArray());
        $this->assertEquals(0, $regions->count());
    }

    public function test_can_get_regions_by_country()
    {
        $regions = World::countries('Iran')->regions()->get();

        $this->assertIsArray($regions->toArray());
        $this->assertEquals(0, $regions->count());
    }

}
