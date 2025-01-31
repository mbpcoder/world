<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;

class ProvinceRepository extends Repository
{
    private Location|null $province;

    private $provinceQuery;

    private ContinentRepository $continentRepository;
    private CountryRepository $countryRepository;
    private ProvinceRepository $provinceRepository;
    private CityRepository $cityRepository;

    public function __construct()
    {
        $this->continentRepository = new ContinentRepository();
        $this->countryRepository = new CountryRepository();
        $this->provinceRepository = new ProvinceRepository();
        $this->cityRepository = new CityRepository();

        $this->provinceQuery = DB::table("locations")
            ->where('type', LocationType::PROVINCE->value)
            ->query();

        parent::__construct();
    }

    public function setProvince(Location $province): self
    {
        $this->province = $province;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        if ($this->province !== null) {
            $this->continentRepository->whereIdEqual($this->province->continentId);
        }
        return $this->continentRepository;
    }

    public function country(): CountryRepository
    {
        if ($this->province !== null) {
            $this->countryRepository->whereIdEqual($this->province->countryId);
        }
        return $this->countryRepository;
    }

    public function cities(): CityRepository
    {
        if ($this->province !== null) {
            $this->cityRepository->whereProvinceIdEqual($this->province->id);
        }
        return $this->cityRepository;
    }

    public function get(): Location|Collection
    {
        if ($this->province !== null) {
            return $this->province;
        }
        $entities = $this->provinceQuery->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    // Query Base Functions

    public function whereContinentIdEqual(int $continentId): self
    {
        $this->provinceQuery->where("continent_id", $continentId);
        return $this;
    }

    public function whereEnglishNameEqual(string $englishName): self
    {
        $entity = $this->provinceQuery->where("english_name", $englishName)->first();
        $this->province = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereNativeNameEqual(string $nativeName): self
    {
        $entity = $this->provinceQuery->where("native_name", $nativeName)->first();
        $this->province = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereIdEqual(int $id): self
    {
        $entity = $this->provinceQuery->where("id", $id)->first();
        $this->province = $this->locationFactory->make($entity);
        return $this;
    }
}