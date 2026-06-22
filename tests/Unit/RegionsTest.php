<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class RegionsTest extends TestCase
{
    public function test_can_get_regions()
    {
        $regions = World::regions()->get();

        $this->assertIsArray($regions->toArray());
        $this->assertEquals(68, $regions->count());
    }

    public function test_can_get_regions_by_country_with_region_tier()
    {
        // Italy has a region tier above its provinces.
        $regions = World::countries('Italy')->regions()->get();
        $this->assertEquals(19, $regions->count());
    }

    public function test_can_get_regions_by_country_without_region_tier()
    {
        // Iran has no region tier; its states map directly to provinces.
        $regions = World::countries('Iran')->regions()->get();
        $this->assertEquals(0, $regions->count());
    }

    public function test_can_get_country_and_provinces_by_region()
    {
        $abruzzo = World::regions('Abruzzo')->first();
        $this->assertNotNull($abruzzo);

        $italy = World::regions('Abruzzo')->country()->first();
        $this->assertEquals('Italy', $italy->englishName);

        $provinces = World::regions('Abruzzo')->provinces()->get();
        $this->assertEquals(4, $provinces->count());
    }

}
