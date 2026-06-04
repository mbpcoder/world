<?php

namespace TheCoder\World\Seeders;

use Illuminate\Support\Facades\DB;
use TheCoder\World\Facades\World;
use TheCoder\World\Spatial\Point;
use Illuminate\Database\Seeder;

class WorldLocationTableSeeder extends Seeder
{
    private string $tableName;

    // Maps dr5hn region/subregion to our continent ISO codes and names.
    private const CONTINENT_MAP = [
        'Africa'  => ['iso_code' => 'AF', 'name' => 'Africa'],
        'Asia'    => ['iso_code' => 'AS', 'name' => 'Asia'],
        'Europe'  => ['iso_code' => 'EU', 'name' => 'Europe'],
        'Oceania' => ['iso_code' => 'OC', 'name' => 'Oceania'],
        'Polar'   => ['iso_code' => 'AN', 'name' => 'Antarctica'],
        'NA'      => ['iso_code' => 'NA', 'name' => 'North America'],
        'SA'      => ['iso_code' => 'SA', 'name' => 'South America'],
    ];

    public function run(): void
    {
        $this->tableName = config('world.table_name');

        $data = $this->loadData();

        $continentIdMap = $this->seedContinents($data);
        $countryIdMap   = $this->seedCountries($data, $continentIdMap);
        $this->seedProvincesAndCities($data, $continentIdMap, $countryIdMap);

        World::clearCache();
    }

    private function seedContinents(array $data): array
    {
        $records = [];
        $seen    = [];

        foreach ($data as $country) {
            $sourceId = $this->continentSourceId($country);
            if (isset($seen[$sourceId])) {
                continue;
            }
            $seen[$sourceId] = true;

            $key  = $this->continentKey($country);
            $info = self::CONTINENT_MAP[$key] ?? ['iso_code' => 'XX', 'name' => (string) $country->region];

            $records[] = [
                'source_id'    => $sourceId,
                'continent_id' => null,
                'country_id'   => null,
                'region_id'    => null,
                'province_id'  => null,
                'iso_code'     => $info['iso_code'],
                'type'         => 'continent',
                'english_name' => $info['name'],
                'native_name'  => $info['name'],
                'timezone'     => null,
                'is_capital'   => false,
                'center'       => null,
                'area'         => null,
                'priority'     => 0,
            ];
        }

        DB::table($this->tableName)->upsert(
            $records,
            ['source_id'],
            ['iso_code', 'english_name', 'native_name']
        );

        return DB::table($this->tableName)
            ->where('type', 'continent')
            ->whereNotNull('source_id')
            ->pluck('id', 'source_id')
            ->toArray();
    }

    private function seedCountries(array $data, array $continentIdMap): array
    {
        $records = [];

        foreach ($data as $country) {
            $continentId = $continentIdMap[$this->continentSourceId($country)] ?? null;
            $timezone    = $country->timezones[0]->zoneName ?? null;

            $records[] = [
                'source_id'    => 'country:' . $country->iso2,
                'continent_id' => $continentId,
                'country_id'   => null,
                'region_id'    => null,
                'province_id'  => null,
                'iso_code'     => $country->iso3 ?? $country->iso2,
                'type'         => 'country',
                'english_name' => $country->name,
                'native_name'  => $country->native ?? $country->name,
                'timezone'     => $timezone,
                'is_capital'   => false,
                'center'       => $this->makePoint($country->latitude ?? null, $country->longitude ?? null),
                'area'         => null,
                'priority'     => 0,
            ];
        }

        DB::table($this->tableName)->upsert(
            $records,
            ['source_id'],
            ['continent_id', 'iso_code', 'english_name', 'native_name', 'timezone', 'center']
        );

        return DB::table($this->tableName)
            ->where('type', 'country')
            ->whereNotNull('source_id')
            ->pluck('id', 'source_id')
            ->toArray();
    }

    private function seedProvincesAndCities(array $data, array $continentIdMap, array $countryIdMap): void
    {
        foreach ($data as $country) {
            if (empty($country->states)) {
                continue;
            }

            $continentId = $continentIdMap[$this->continentSourceId($country)] ?? null;
            $countryId   = $countryIdMap['country:' . $country->iso2] ?? null;
            $timezone    = $country->timezones[0]->zoneName ?? null;
            $capital     = $country->capital ?? null;

            $provinceRecords = [];
            foreach ($country->states as $state) {
                $provinceRecords[] = [
                    'source_id'    => 'state:' . $state->id,
                    'continent_id' => $continentId,
                    'country_id'   => $countryId,
                    'region_id'    => null,
                    'province_id'  => null,
                    'iso_code'     => null,
                    'type'         => 'province',
                    'english_name' => $state->name,
                    'native_name'  => $state->name,
                    'timezone'     => $timezone,
                    'is_capital'   => false,
                    'center'       => $this->makePoint($state->latitude ?? null, $state->longitude ?? null),
                    'area'         => null,
                    'priority'     => 0,
                ];
            }

            DB::table($this->tableName)->upsert(
                $provinceRecords,
                ['source_id'],
                ['continent_id', 'country_id', 'english_name', 'native_name', 'timezone', 'center']
            );

            $provinceSourceIds = array_column($provinceRecords, 'source_id');
            $provinceIdMap = DB::table($this->tableName)
                ->whereIn('source_id', $provinceSourceIds)
                ->pluck('id', 'source_id')
                ->toArray();

            $cityRecords = [];
            foreach ($country->states as $state) {
                $provinceId = $provinceIdMap['state:' . $state->id] ?? null;

                foreach ($state->cities as $city) {
                    $cityRecords[] = [
                        'source_id'    => 'city:' . $city->id,
                        'continent_id' => $continentId,
                        'country_id'   => $countryId,
                        'region_id'    => null,
                        'province_id'  => $provinceId,
                        'iso_code'     => null,
                        'type'         => 'city',
                        'english_name' => $city->name,
                        'native_name'  => $city->name,
                        'timezone'     => $timezone,
                        'is_capital'   => ($capital !== null && $city->name === $capital),
                        'center'       => $this->makePoint($city->latitude ?? null, $city->longitude ?? null),
                        'area'         => null,
                        'priority'     => 0,
                    ];

                    if (count($cityRecords) >= 500) {
                        DB::table($this->tableName)->upsert(
                            $cityRecords,
                            ['source_id'],
                            ['continent_id', 'country_id', 'province_id', 'english_name', 'native_name', 'timezone', 'center', 'is_capital']
                        );
                        $cityRecords = [];
                    }
                }
            }

            if (!empty($cityRecords)) {
                DB::table($this->tableName)->upsert(
                    $cityRecords,
                    ['source_id'],
                    ['continent_id', 'country_id', 'province_id', 'english_name', 'native_name', 'timezone', 'center', 'is_capital']
                );
            }
        }
    }

    private function makePoint($latitude, $longitude)
    {
        if ($latitude === null || $latitude === '' || $longitude === null || $longitude === '') {
            return null;
        }
        $point = new Point((float) $latitude, (float) $longitude);
        return $point->isEmpty() ? null : $point->getSqlFromText();
    }

    private function continentKey(object $country): string
    {
        if (($country->region ?? '') === 'Americas') {
            return ($country->subregion ?? '') === 'South America' ? 'SA' : 'NA';
        }
        return $country->region ?? 'Unknown';
    }

    private function continentSourceId(object $country): string
    {
        return 'continent:' . $this->continentKey($country);
    }

    protected function loadData(): array
    {
        $localPath = __DIR__ . '/countries+states+cities.json';

        if (!file_exists($localPath)) {
            $url = config('world.data_url');
            if (!$url) {
                throw new \RuntimeException('world.data_url is not configured.');
            }
            if (!copy($url, $localPath)) {
                throw new \RuntimeException("Failed to download locations data from: {$url}");
            }
        }

        return json_decode(file_get_contents($localPath));
    }
}
