<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\LocationFactory;
use TheCoder\World\LocationType;

class Repository
{
    use MySqlRepository;

    public function __construct(
        protected LocationFactory   $locationFactory = new LocationFactory(),
        protected RepositoryFactory $repositoryFactory = new RepositoryFactory()
    )
    {
        $this->query = $this->getNewQuery();
    }
}
