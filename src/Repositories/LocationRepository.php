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
        return config('world.cache.prefix') . md5($functionName . $query->toRawSql());
    }
}
