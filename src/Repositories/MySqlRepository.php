<?php

namespace TheCoder\World\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use TheCoder\World\Location;
use TheCoder\World\LocationFactory;
use TheCoder\World\LocationType;

trait MySqlRepository
{
    protected Builder $query;

    protected function getNewQuery(): Builder
    {
        return $this->query = DB::table(config('world.table_name'))->where('type', $this->locationType->value);
    }

    protected function hasWhereConditions(): bool
    {
        return count($this->query->wheres) > 1;
    }

    /**
     * @return Collection<Location>
     */
    public function get(): Collection
    {
        $entities = $this->query->get();
        return $this->locationFactory->makeFromCollection($entities);
    }

    public function first(): Location|null
    {
        $entity = $this->query->first();
        return $this->locationFactory->make($entity);
    }

    public function count(): int
    {
        return $this->query->count();
    }

    public function idEqual(int $id): self
    {
        $this->query->where('id', $id);
        return $this;
    }

    public function englishNameEqual(string $englishName): self
    {
        $this->query->where('english_name', $englishName);
        return $this;
    }

    public function nativeNameEqual(string $nativeName): self
    {
        $this->query->where("native_name", $nativeName);
        return $this;
    }

    public function continentIdEqual(int $continentId): self
    {
        $this->query->where("continent_id", $continentId);
        return $this;
    }

    public function countryIdEqual(int $countryId): self
    {
        $this->query->where("country_id", $countryId);
        return $this;
    }

    public function regionIdEqual(int $regionId): self
    {
        $this->query->where("region_id", $regionId);
        return $this;
    }

    public function provinceIdEqual(int $provinceId): self
    {
        $this->query->where("province_id", $provinceId);
        return $this;
    }
}
