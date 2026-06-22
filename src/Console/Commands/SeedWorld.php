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

        if ($this->option('fresh-data') && file_exists($localPath)) {
            unlink($localPath);
        }

        if (!file_exists($localPath)) {
            $this->info('Downloading data from ' . config('world.data_url') . ' ...');
        }

        Artisan::call('db:seed', [
            '--class' => WorldLocationTableSeeder::class,
            '--force' => true,
        ]);

        $this->info('World data seeded successfully!');
    }
}
