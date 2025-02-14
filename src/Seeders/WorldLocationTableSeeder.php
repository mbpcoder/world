<?php

namespace TheCoder\World\Seeders;

use Illuminate\Support\Facades\DB;
use TheCoder\World\Spatial\Point;
use Illuminate\Database\Seeder;

class WorldLocationTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->truncate();

        $data = $this->loadData();

        $chunkSize = 1000;

        foreach (array_chunk($data, $chunkSize) as $chunk) {
            $insertData = [];

            foreach ($chunk as $item) {

                $pointSql = null;
                if ($item->center !== null) {
                    $point = new Point();
                    $point->parse($item->center);
                    $pointSql = $point->getSqlFromText();
                }

                $insertData[] = [
                    'id' => $item->id,
                    'continent_id' => $item->continent_id,
                    'country_id' => $item->country_id,
                    'province_id' => $item->province_id,
                    'iso_code' => $item->iso_code,
                    'type' => $item->type,
                    'native_name' => $item->native_name,
                    'english_name' => $item->english_name,
                    'timezone' => $item->timezone,
                    'is_capital' => $item->is_capital,
                    'center' => $pointSql,
                    'area' => $item->area,
                    'priority' => $item->priority,
                ];
            }

            DB::table('locations')->insert($insertData);
        }
    }

    protected function loadData(): array
    {
        $json = file_get_contents(__DIR__ . '/locations.json');
        return json_decode($json);
    }
}
