<?php

namespace TheCoder\World\Tests\Unit;

use Illuminate\Support\Facades\DB;
use TheCoder\World\Tests\TestCase;

class SeedersTest extends TestCase
{
    public function test_seeds_run_correctly()
    {
        $count = DB::table('locations')->count();

        $this->assertGreaterThan(0, $count);
    }
}
