<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;

class CityRepository extends Repository
{
    private Location|null $city;

    private $cityQuery;

    private ContinentRepository $continentRepository;
    private CountryRepository $countryRepository;
    private ProvinceRepository $provinceRepository;

    public function __construct()
    {
        $this->continentRepository = new ContinentRepository();
        $this->countryRepository = new CountryRepository();
        $this->provinceRepository = new ProvinceRepository();

        $this->cityQuery = DB::table("locations")
            ->where('type', LocationType::CITY->value)
            ->query();

        parent::__construct();
    }

    public function setCity(Location $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        if ($this->city !== null) {
            $this->continentRepository->whereIdEqual($this->city->continentId);
        }
        return $this->continentRepository;
    }

    public function country(): CountryRepository
    {
        if ($this->city !== null) {
            $this->countryRepository->whereIdEqual($this->city->countryId);
        }
        return $this->countryRepository;
    }

    public function province(): CountryRepository
    {
        if ($this->city !== null) {
            $this->countryRepository->whereIdEqual($this->city->provinceId);
        }
        return $this->countryRepository;
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