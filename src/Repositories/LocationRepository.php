<?php

namespace TheCoder\World\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use TheCoder\World\Location;
use TheCoder\World\LocationFactory;

trait LocationRepository
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

    protected function cachePut(string|null $cacheKey, mixed $data): void
    {
        $ttl = config('world.cache.ttl');
        $tag = config('world.cache.tag');

        if ($cacheKey !== null) {
            if (Cache::supportsTags() && $tag !== null) {
                $cache = Cache::tags($tag);
            } else {
                $cache = Cache::store();
            }

            $ttl === null ? $cache->forever($cacheKey, $data) : $cache->put($cacheKey, $data, $ttl);
        }
    }

    protected function cacheGet(string|null $cacheKey): mixed
    {
        $tag = config('world.cache.tag');
        if (Cache::supportsTags() && $tag !== null) {
            return Cache::tags($tag)->get($cacheKey);
        }
        return Cache::get($cacheKey);
    }

    protected function makeCacheKey(Builder $query, string $functionName): string
    {
        if (method_exists($query, 'toRawSql')) {
            $sql = md5($functionName . $query->toRawSql());
        } else {
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $sql = str_replace(['?'], $bindings, $sql);
        }
        return config('world.cache.prefix') . md5($functionName . $sql);
    }

    /**
     * @return Collection<Location>
     */
    public function get(): Collection
    {
        $cacheKey = null;
        if (config('world.cache.enabled')) {
            $cacheKey = $this->makeCacheKey($this->query, __FUNCTION__);
            $result = $this->cacheGet($cacheKey);
            if ($result !== null) {
                return $result;
            }
        }

        $entities = $this->query->get();
        $locations = $this->locationFactory->makeFromCollection($entities);

        if ($cacheKey !== null) {
            $this->cachePut($cacheKey, $locations);
        }
        return $locations;
    }

    public function first(): Location|null
    {
        $this->query->take(1);

        $cacheKey = null;
        if (config('world.cache.enabled')) {
            $cacheKey = $this->makeCacheKey($this->query, __FUNCTION__);
            $result = $this->cacheGet($cacheKey);
            if ($result !== null) {
                return $result;
            }
        }

        $entity = $this->query->get()->first();
        $location = $this->locationFactory->make($entity);

        $this->cachePut($cacheKey, $location);

        return $location;
    }

    public function count(): int
    {
        $cacheKey = null;
        if (config('world.cache.enabled')) {
            $cacheKey = $this->makeCacheKey($this->query, __FUNCTION__);
            $result = $this->cacheGet($cacheKey);
            if ($result !== null) {
                return $result;
            }
        }

        $count = $this->query->count();

        $this->cachePut($cacheKey, $count);

        return $count;
    }

    public function byId(int $id): self
    {
        $this->query->where('id', $id);
        return $this;
    }

    public function byContinentId(int $continentId): self
    {
        $this->query->where("continent_id", $continentId);
        return $this;
    }

    public function byCountryId(int $countryId): self
    {
        $this->query->where("country_id", $countryId);
        return $this;
    }

    public function byRegionId(int $regionId): self
    {
        $this->query->where("region_id", $regionId);
        return $this;
    }

    public function byProvinceId(int $provinceId): self
    {
        $this->query->where("province_id", $provinceId);
        return $this;
    }

    public function byIds(array $ids): self
    {
        $this->query->whereIn('id', $ids);
        return $this;
    }

    public function byEnglishName(string $englishName): self
    {
        $this->query->where('english_name', $englishName);
        return $this;
    }

    public function byEnglishNames(array $englishNames): self
    {
        $this->query->whereIN('english_name', $englishNames);
        return $this;
    }

    public function byNativeName(string $nativeName): self
    {
        $this->query->where("native_name", $nativeName);
        return $this;
    }

    public function byNativeNames(array $nativeNames): self
    {
        $this->query->whereIn("native_name", $nativeNames);
        return $this;
    }
}
