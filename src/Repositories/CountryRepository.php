<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;
use Illuminate\Support\Facades\DB;

class CountryRepository extends Repository
{
    protected Location|null $country = null;
    protected $countryQuery;

    public function __construct()
    {
        $this->countryQuery = DB::table("locations")
            ->where('type', LocationType::COUNTRY->value);

        parent::__construct();
    }

    public function setCountry(Location $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        $continentRepository =  $this->repositoryFactory->getContinentRepository();
        if ($this->country !== null) {
            $continentRepository->whereIdEqual($this->country->continentId);
        }
        return $continentRepository;
    }

    public function provinces(): ProvinceRepository
    {
        return $this->repositoryFactory->getProvinceRepository();
    }

    public function cities(): CityRepository
    {
        return $this->repositoryFactory->getCityRepository();
    }

    public function count(): int
    {
        if ($this->country !== null) {
            return $this->countryQuery->whereIdEqual($this->country->id)->count();
        }
        return $this->countryQuery->count();
    }

    public function get(): Location|Collection
    {
        if ($this->country !== null) {
            return $this->country;
        }
        $entities = $this->countryQuery->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    // Query Base Functions

    public function whereContinentIdEqual(int $id): self
    {
        $this->countryQuery->where("continent_id", $id);
        return $this;
    }

    public function whereEnglishNameEqual(string $englishName): self
    {
        $entity = $this->countryQuery->where("english_name", $englishName)->first();
        $this->country = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereNativeNameEqual(string $nativeName): self
    {
        $entity = $this->countryQuery->where("native_name", $nativeName)->first();
        $this->country = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereIdEqual(int $id): self
    {
        $entity = $this->countryQuery->where("id", $id)->first();
        $this->country = $this->locationFactory->make($entity);
        return $this;
    }
}
