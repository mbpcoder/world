<?php

use Illuminate\Support\Facades\DB;
use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class ProvinceCapitalsTest extends TestCase
{
    private function markTehranAsProvinceCapital(): void
    {
        DB::table(config('world.table_name'))
            ->where('type', 'city')
            ->where('english_name', 'Tehran')
            ->where('country_id', DB::table(config('world.table_name'))->where('type', 'country')->where('english_name', 'Iran')->value('id'))
            ->update(['is_province_capital' => true]);
    }

    protected function tearDown(): void
    {
        DB::table(config('world.table_name'))->update(['is_province_capital' => false]);
        parent::tearDown();
    }

    public function test_province_capitals_is_empty_when_nothing_is_flagged()
    {
        $this->assertSame(0, World::provinceCapitals()->count());
    }

    public function test_world_province_capitals()
    {
        $this->markTehranAsProvinceCapital();

        $capitals = World::provinceCapitals()->get();

        $this->assertTrue($capitals->every(fn($location) => $location->isProvinceCapital));
        $this->assertContains('Tehran', $capitals->pluck('englishName')->all());
    }

    public function test_continent_province_capitals()
    {
        $this->markTehranAsProvinceCapital();

        $this->assertContains('Tehran', World::continents('Asia')->provinceCapitals()->get()->pluck('englishName')->all());
    }

    public function test_continent_province_capitals_excludes_other_continents()
    {
        $this->markTehranAsProvinceCapital();

        $this->assertSame(0, World::continents('Europe')->provinceCapitals()->count());
    }

    public function test_country_province_capitals()
    {
        $this->markTehranAsProvinceCapital();

        $this->assertContains('Tehran', World::countries('Iran')->provinceCapitals()->get()->pluck('englishName')->all());
    }

    public function test_country_province_capitals_excludes_other_countries()
    {
        $this->markTehranAsProvinceCapital();

        $this->assertSame(0, World::countries('Italy')->provinceCapitals()->count());
    }

    public function test_region_province_capitals_only_returns_flagged_cities()
    {
        $region = World::regions()->first();
        $this->assertNotNull($region);

        $this->assertSame(0, World::regions($region->id)->provinceCapitals()->count());
    }
}
