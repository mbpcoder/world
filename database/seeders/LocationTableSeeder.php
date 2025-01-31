<?php

namespace TheCoder\World\database\seeders;

use Illuminate\Support\Facades\DB;
use TheCoder\World\Spatial\Point;

class LocationTableSeeder
{
    public function run()
    {
        // Read the JSON file
        $json = file_get_contents('locations.json');
        $data = json_decode($json);

        // Insert each item into the continents table
        foreach ($data as $item) {
            if ($item->center !== null) {
                $point = new Point();
                $point->parse($item->center);
            }

            DB::table('locations')->insert([
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
                'center' => isset($point) ? $point?->getSqlFromText() : null,
                'area' => $item->area,
                'priority' => $item->priority,
            ]);
        }
    }
}