<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationFactory;

class Repository
{
    public function __construct(
        protected LocationFactory $locationFactory = new LocationFactory()
    )
    {
    }
}