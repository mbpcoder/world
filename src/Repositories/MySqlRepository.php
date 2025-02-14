<?php

namespace TheCoder\World\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use TheCoder\World\Location;
use TheCoder\World\LocationFactory;

trait MySqlRepository
{
    protected Builder $query;

    protected function getNewQuery(): Builder
    {
        return DB::table(config('world.table_name'));
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

    public function provinceIdEqual(int $provinceId): self
    {
        $this->query->where("province_id", $provinceId);
        return $this;
    }

//    protected function where(string $column, string|int|null|bool $operator = null, string|int|null|bool $value = null): self
//    {
//        if ($value === null) {
//            $value = $operator;
//            $operator = '=';
//        }
//
//        $this->query->where($column, $operator, $englishName);
//        return $this;
//    }
}
