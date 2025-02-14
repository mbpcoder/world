<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;
use Illuminate\Support\Facades\DB;

class ContinentRepository extends Repository
{
    protected Location|null $continent = null;
    protected $continentQuery;

    public function __construct()
    {
        $this->continentQuery = DB::table("locations")
            ->where('type', LocationType::CONTINENT->value);

        parent::__construct();
    }

    public function setContinent(Location $continent): self
    {
        $this->continent = $continent;
        return $this;
    }

    public function countries(): CountryRepository
    {
        $countryRepository = $this->repositoryFactory->getCountryRepository();
        if ($this->continent !== null) {
            $countryRepository->whereContinentIdEqual($this->continent->id);
        }
        return $countryRepository;
    }

    public function provinces(): ProvinceRepository
    {
        $provinceRepository = $this->repositoryFactory->getProvinceRepository();
        if ($this->continent !== null) {
            $provinceRepository->whereContinentIdEqual($this->continent->id);
        }
        return $this->provinceRepository;
    }

    public function cities(): CityRepository
    {
        $cityRepository = $this->repositoryFactory->getCityRepository();
        if ($this->continent !== null) {
            $cityRepository->whereContinentIdEqual($this->continent->id);
        }
        return $cityRepository;
    }

    public function count(): int
    {
        if ($this->continent !== null) {
            return 1;
        }
        return $this->continentQuery->count();
    }

    public function get(): Location|Collection
    {
        if ($this->continent !== null) {
            return $this->continent;
        }
        $entities = $this->continentQuery->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    // Query Base Functions

    public function whereEnglishNameEqual(string $englishName): self
    {
        $entity = $this->continentQuery->where("english_name", $englishName)->first();
        $this->continent = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereNativeNameEqual(string $nativeName): self
    {
        $entity = $this->continentQuery->where("native_name", $nativeName)->first();
        $this->continent = $this->locationFactory->make($entity);
        return $this;
    }

    public function whereIdEqual(int $id): self
    {
        $entity = $this->continentQuery->where("id", $id)->first();
        $this->continent = $this->locationFactory->make($entity);
        return $this;
    }
}
