<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;
use Illuminate\Support\Facades\DB;

class CityRepository extends Repository
{
    protected Location|null $city = null;
    protected $cityQuery;

    public function __construct()
    {
        $this->cityQuery = DB::table("locations")
            ->where('type', LocationType::CITY->value);

        parent::__construct();
    }

    public function setCity(Location $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        $continentRepository = $this->repositoryFactory->getContinentRepository();
        if ($this->city !== null) {
            $continentRepository->whereIdEqual($this->city->continentId);
        }
        return $continentRepository;
    }

    public function country(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();
        if ($this->city !== null) {
            $countryRepository->whereIdEqual($this->city->countryId);
        }
        return $countryRepository;
    }

    public function province(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();
        if ($this->city !== null) {
            $provinceRepository->whereIdEqual($this->city->provinceId);
        }
        return $provinceRepository;
    }

    public function getOne(): Location|null
    {
        return $this->city;
    }

    public function getAll(): Collection
    {
        $entities = $this->cityQuery->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    public function get(): Location|Collection
    {
        if ($this->city !== null) {
            return $this->city;
        }
        $entities = $this->cityQuery->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    // Query Base Functions

    public function whereContinentIdEqual(int $continentId): self
    {
        $this->cityQuery->where("continent_id", $continentId);
        return $this;
    }

    public function whereEnglishNameEqual(string $englishName): self
    {
        $entity = $this->cityQuery->where("english_name", $englishName)->first();
        $this->city = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereNativeNameEqual(string $nativeName): self
    {
        $entity = $this->cityQuery->where("native_name", $nativeName)->first();
        $this->city = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereIdEqual(int $id): self
    {
        $entity = $this->cityQuery->where("id", $id)->first();
        $this->city = $this->locationFactory->make($entity);
        return $this;
    }
}
