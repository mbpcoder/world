<?php

namespace TheCoder\World\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use TheCoder\World\Seeders\WorldLocationTableSeeder;

class SeedWorld extends Command
{
    protected $signature = 'world:seed {--fresh-data : Re-download the source data file even if a local copy exists}';
    protected $description = 'Seed the World database';

    public function handle()
    {
        $this->info('Seeding World data...');

        $localPath = database_path('seeders/countries+states+cities.json');
        $statesMetadataPath = database_path('seeders/states.json');

        if ($this->option('fresh-data')) {
            if (file_exists($localPath)) {
                unlink($localPath);
            }
            if (file_exists($statesMetadataPath)) {
                unlink($statesMetadataPath);
            }
        }

        if (!file_exists($localPath)) {
            $this->info('Downloading data from ' . config('world.data_url') . ' ...');
        }
        if (!file_exists($statesMetadataPath)) {
            $this->info('Downloading states metadata from ' . config('world.states_data_url') . ' ...');
        }

        Artisan::call('db:seed', [
            '--class' => WorldLocationTableSeeder::class,
            '--force' => true,
        ]);

        $this->info('World data seeded successfully!');
    }
}
