<?php

namespace TheCoder\World\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as Orchestra;
use TheCoder\World\WorldServiceProvider;

abstract class TestCase extends Orchestra
{
    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$migrated) {
            $this->artisan('migrate')->run();
            $this->artisan('world:seed')->run();
            $this->artisan('cache:clear');
            static::$migrated = true;
        }
    }

    protected function getPackageProviders($app)
    {
        return [WorldServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'World' => \TheCoder\World\Facades\World::class,
        ];
    }
}
