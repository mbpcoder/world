<?php

namespace TheCoder\World\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use TheCoder\World\Tests\TestCase;
use TheCoder\World\WorldServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function test_config_is_merged()
    {
        $this->assertEquals('locations', config('world.table_name'));
        $this->assertArrayHasKey('cache', config('world'));
    }

    public function test_seed_command_is_registered()
    {
        $this->assertArrayHasKey('world:seed', Artisan::all());
    }

    public function test_world_alias_is_registered()
    {
        $this->assertTrue(class_exists('World'));
    }

    public function test_publishable_groups_are_registered()
    {
        $groups = ServiceProvider::$publishGroups;

        $this->assertArrayHasKey('world-config', $groups);
        $this->assertArrayHasKey('world-migrations', $groups);
    }

    public function test_provider_publishes_config_file()
    {
        $paths = ServiceProvider::pathsToPublish(WorldServiceProvider::class, 'world-config');

        $this->assertContains(config_path('world.php'), $paths);
    }
}
