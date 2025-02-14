<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;
use Illuminate\Support\Facades\DB;

class ProvinceRepository extends Repository
{
    protected Location|null $province = null;
    protected $provinceQuery;

    public function __construct()
    {
        $this->provinceQuery = DB::table("locations")
            ->where('type', LocationType::PROVINCE->value);

        parent::__construct();
    }

    public function setProvince(Location $province): self
    {
        $this->province = $province;
        return $this;
    }

    public function continent(): ContinentRepository
    {
        $continentRepository = $this->repositoryFactory->getContinentRepository();
        if ($this->province !== null) {
            $continentRepository->whereIdEqual($this->province->continentId);
        }
        return $continentRepository;
    }

    public function country(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();
        if ($this->province !== null) {
            $countryRepository->whereIdEqual($this->province->countryId);
        }
        return $countryRepository;
    }

    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();
        if ($this->province !== null) {
            $cityRepository->whereProvinceIdEqual($this->province->id);
        }
        return $cityRepository;
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
