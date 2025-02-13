<?php

namespace TheCoder\World\Facades;

use Illuminate\Support\Facades\Facade;

class World extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TheCoder\World\World::class;
    }
}
