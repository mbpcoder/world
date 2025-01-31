<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use TheCoder\World\LocationFactory;

trait LocationRepository
{
    protected Location|null $location;
    protected LocationFactory $locationFactory;
    protected $locationQuery;

    public function __construct()
    {
        $this->locationQuery = DB::table("locations")->query();
        $this->locationFactory = new LocationFactory();
    }

    public function whereEnglishNameEqual(string $name): self
    {
        $entity = $this->locationQuery->where("name", $name)->first();
        $this->location = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereIdEqual(int $id): self
    {
        $entity = $this->locationQuery->where("id", $id)->first();
        $this->location = $this->locationFactory->make($entity);
        return $this;
    }
}