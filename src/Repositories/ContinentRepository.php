<?php

namespace TheCoder\World\Repositories;

use TheCoder\World\Location;
use Illuminate\Support\Collection;
use TheCoder\World\LocationType;

class ContinentRepository extends Repository
{
    private Location|null $continent;

    private $continentQuery;

    private CountryRepository $countryRepository;
    private ProvinceRepository $provinceRepository;
    private CityRepository $cityRepository;

    public function __construct()
    {
        $this->countryRepository = new CountryRepository();
        $this->provinceRepository = new ProvinceRepository();
        $this->cityRepository = new CityRepository();

        $this->continentQuery = DB::table("locations")
            ->where('type', LocationType::CONTINENT->value)
            ->query();

        parent::__construct();
    }

    public function setContinent(Location $continent): self
    {
        $this->continent = $continent;
        return $this;
    }

    public function countries(): CountryRepository
    {
        if ($this->continent !== null) {
            $this->countryRepository->whereContinentIdEqual($this->continent->id);
        }
        return $this->countryRepository;
    }

    public function provinces(): ProvinceRepository
    {
        if ($this->continent !== null) {
            $this->provinceRepository->whereContinentIdEqual($this->continent->id);
        }
        return $this->provinceRepository;
    }

    public function cities(): CityRepository
    {
        if ($this->continent !== null) {
            $this->cityRepository->whereContinentIdEqual($this->continent->id);
        }
        return $this->cityRepository;
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