<?php

namespace TheCoder\World\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use TheCoder\World\Seeders\WorldLocationTableSeeder;

class SeedWorld extends Command
{
    protected $signature = 'world:seed';
    protected $description = 'Seed the World database';

    public function handle()
    {
        $this->info('Seeding World data...');

        Artisan::call('db:seed', [
            '--class' => WorldLocationTableSeeder::class,
            '--force' => true,
        ]);

        $this->info('World data seeded successfully!');
    }
}
