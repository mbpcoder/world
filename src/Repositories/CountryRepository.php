<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;

class CountryRepository extends Repository
{
    private Location|null $country;

    private $countryQuery;

    private ContinentRepository $continentRepository;
    private ProvinceRepository $provinceRepository;
    private CityRepository $cityRepository;

    public function __construct()
    {
        $this->continentRepository = new ContinentRepository();
        $this->provinceRepository = new ProvinceRepository();
        $this->cityRepository = new CityRepository();

        $this->countryQuery = DB::table("locations")
            ->where('type', LocationType::COUNTRY->value)
            ->query();

        parent::__construct();
    }

    public function setCountry(Location $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        if ($this->country !== null) {
            $this->continentRepository->whereIdEqual($this->country->continentId);
        }
        return $this->continentRepository;
    }

    public function provinces(): ProvinceRepository
    {
        return $this->provinceRepository;
    }

    public function cities(): CityRepository
    {
        return $this->cityRepository;
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
