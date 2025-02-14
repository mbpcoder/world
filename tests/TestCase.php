<?php

namespace TheCoder\World\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use TheCoder\World\WorldServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (!getenv('SKIP_DB_SETUP')) {
            $this->artisan('migrate')->run();
            $this->artisan('world:seed')->run();
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
