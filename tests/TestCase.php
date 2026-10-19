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
            // Use a fresh migration rather than `migrate` so stale rows left
            // over in a persistent local test database by a previous run
            // (e.g. before a seeder bug fix) can never leak into this one.
            $this->artisan('migrate:fresh')->run();
            $this->artisan('world:seed')->run();
            $this->artisan('cache:clear');
            static::$migrated = true;
        }
    }

    protected function getEnvironmentSetUp($app)
    {
        // An in-memory SQLite database is recreated for every test, but the
        // suite seeds only once, so SQLite needs a file that survives between tests.
        $connection = $app['config']->get('database.default');

        if ($app['config']->get("database.connections.$connection.driver") === 'sqlite') {
            $path = sys_get_temp_dir() . '/world_test_database.sqlite';
            touch($path);
            $app['config']->set("database.connections.$connection.database", $path);
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
