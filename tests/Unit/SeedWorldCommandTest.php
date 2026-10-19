<?php

namespace TheCoder\World\Tests\Unit;

use Illuminate\Support\Facades\DB;
use TheCoder\World\Tests\TestCase;

class SeedWorldCommandTest extends TestCase
{
    public function test_seed_command_succeeds_and_reports_progress()
    {
        $this->artisan('world:seed')
            ->expectsOutputToContain('Seeding World data')
            ->expectsOutputToContain('World data seeded successfully')
            ->assertExitCode(0);
    }

    public function test_seed_command_is_idempotent()
    {
        $before = DB::table(config('world.table_name'))->count();

        $this->artisan('world:seed')->assertExitCode(0);

        $this->assertSame($before, DB::table(config('world.table_name'))->count());
    }

    public function test_seed_command_exposes_fresh_data_option()
    {
        $definition = $this->app->make(\Illuminate\Contracts\Console\Kernel::class)->all()['world:seed']->getDefinition();

        $this->assertTrue($definition->hasOption('fresh-data'));
    }
}
