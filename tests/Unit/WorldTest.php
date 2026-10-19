<?php

namespace TheCoder\World\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use TheCoder\World\Facades\World;
use TheCoder\World\Repositories\CityRepository;
use TheCoder\World\Repositories\ContinentRepository;
use TheCoder\World\Repositories\CountryRepository;
use TheCoder\World\Repositories\ProvinceRepository;
use TheCoder\World\Repositories\RegionRepository;
use TheCoder\World\Tests\TestCase;

class WorldTest extends TestCase
{
    private function cacheStore()
    {
        $tag = config('world.cache.tag');

        return Cache::supportsTags() && $tag !== null ? Cache::tags($tag) : Cache::store();
    }

    public function test_methods_return_matching_repositories()
    {
        $this->assertInstanceOf(ContinentRepository::class, World::continents());
        $this->assertInstanceOf(CountryRepository::class, World::countries());
        $this->assertInstanceOf(RegionRepository::class, World::regions());
        $this->assertInstanceOf(ProvinceRepository::class, World::provinces());
        $this->assertInstanceOf(CityRepository::class, World::cities());
    }

    public function test_states_is_an_alias_of_provinces()
    {
        $this->assertInstanceOf(ProvinceRepository::class, World::states());
        $this->assertEquals(World::provinces()->count(), World::states()->count());
    }

    public function test_accepts_string_argument()
    {
        $this->assertEquals('Asia', World::continents('Asia')->first()->englishName);
    }

    public function test_accepts_int_argument()
    {
        $id = World::continents('Asia')->first()->id;

        $this->assertEquals('Asia', World::continents($id)->first()->englishName);
    }

    public function test_accepts_location_argument()
    {
        $iran = World::countries('Iran')->first();

        $provinces = World::countries($iran)->provinces()->get();

        $this->assertCount(31, $provinces);
    }

    public function test_unknown_name_returns_nothing()
    {
        $this->assertNull(World::countries('Atlantis')->first());
    }

    public function test_results_are_cached_when_enabled()
    {
        config(['world.cache.enabled' => true]);
        World::clearCache();

        $this->assertEquals(250, World::countries()->count());

        // The count must now be served from the cache, so an empty cache means a miss.
        $this->assertEquals(250, World::countries()->count());
        $this->assertNotNull(World::countries('Iran')->first());
    }

    public function test_clear_cache_flushes_cached_data()
    {
        config(['world.cache.enabled' => true]);
        $this->cacheStore()->forever('world-test-sentinel', 'value');

        World::clearCache();

        $this->assertNull($this->cacheStore()->get('world-test-sentinel'));
    }

    public function test_clear_cache_does_nothing_when_cache_disabled()
    {
        config(['world.cache.enabled' => false]);
        $this->cacheStore()->forever('world-test-sentinel', 'value');

        World::clearCache();

        $this->assertEquals('value', $this->cacheStore()->get('world-test-sentinel'));

        $this->cacheStore()->forget('world-test-sentinel');
    }
}
