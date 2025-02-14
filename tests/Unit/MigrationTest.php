<?php

namespace TheCoder\World\Tests\Unit;

use TheCoder\World\Tests\TestCase;
use \Illuminate\Support\Facades\Schema;

class MigrationTest extends TestCase
{
    public function test_migrations_run_successfully()
    {
        $this->assertTrue(Schema::hasTable(config('world.table_name')));
    }
}
