<?php

namespace TheCoder\World;

use Illuminate\Support\ServiceProvider;
use TheCoder\World\Console\Commands\SeedWorld;

class WorldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/world.php' => config_path('world.php'),
            ], 'world-config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'world-migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge package config with Laravel's config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/world.php', 'world'
        );

        $this->commands([
            SeedWorld::class,
        ]);
    }
}
