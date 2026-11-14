<?php

use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class RepositoryStateTest extends TestCase
{
    public function test_consecutive_queries_do_not_share_state()
    {
        $iran = World::countries('Iran')->cities()->count();
        $italy = World::countries('Italy')->cities()->count();

        $this->assertNotSame($iran, $italy);
        $this->assertSame($iran, World::countries('Iran')->cities()->count());
    }

    public function test_world_level_queries_do_not_share_state()
    {
        $this->assertSame('Iran', World::byEnglishName('Iran')->first()->englishName);
        $this->assertSame('Italy', World::byEnglishName('Italy')->first()->englishName);
    }
}
