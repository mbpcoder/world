<?php

namespace TheCoder\World\Tests\Unit;

use PHPUnit\Framework\TestCase;
use TheCoder\World\Location;
use TheCoder\World\LocationFactory;
use TheCoder\World\LocationType;

class LocationFactoryTest extends TestCase
{
    private function entity(array $overrides = []): \stdClass
    {
        return (object)array_merge([
            'id' => 1,
            'continent_id' => 2,
            'country_id' => 3,
            'region_id' => 4,
            'province_id' => 5,
            'iso_code' => 'IR',
            'type' => 'country',
            'native_name' => 'ایران',
            'english_name' => 'Iran',
            'timezone' => 'Asia/Tehran',
            'is_capital' => 0,
            'center' => 'POINT(32 53)',
            'area' => null,
            'priority' => 7,
        ], $overrides);
    }

    public function test_make_maps_all_fields()
    {
        $location = (new LocationFactory())->make($this->entity());

        $this->assertInstanceOf(Location::class, $location);
        $this->assertSame(1, $location->id);
        $this->assertSame(2, $location->continentId);
        $this->assertSame(3, $location->countryId);
        $this->assertSame(4, $location->regionId);
        $this->assertSame(5, $location->provinceId);
        $this->assertSame('IR', $location->isoCode);
        $this->assertSame(LocationType::COUNTRY, $location->type);
        $this->assertSame('ایران', $location->nativeName);
        $this->assertSame('Iran', $location->englishName);
        $this->assertSame('Asia/Tehran', $location->timezone);
        $this->assertFalse($location->isCapital);
        $this->assertSame(7, $location->priority);
    }

    public function test_make_parses_center_point()
    {
        $location = (new LocationFactory())->make($this->entity());

        $this->assertSame(32.0, $location->center->getLatitude());
        $this->assertSame(53.0, $location->center->getLongitude());
    }

    public function test_make_with_null_center_gives_empty_point()
    {
        $location = (new LocationFactory())->make($this->entity(['center' => null]));

        $this->assertTrue($location->center->isEmpty());
    }

    public function test_make_flags_capital()
    {
        $location = (new LocationFactory())->make($this->entity(['is_capital' => 1]));

        $this->assertTrue($location->isCapital);
    }

    public function test_make_defaults_missing_fields_to_null()
    {
        $location = (new LocationFactory())->make((object)[
            'id' => 1,
            'type' => 'city',
            'priority' => 0,
            'is_capital' => 0,
            'center' => null,
        ]);

        $this->assertNull($location->continentId);
        $this->assertNull($location->isoCode);
        $this->assertNull($location->englishName);
        $this->assertSame(LocationType::CITY, $location->type);
    }

    public function test_make_throws_on_unknown_type()
    {
        $this->expectException(\ValueError::class);

        (new LocationFactory())->make($this->entity(['type' => 'galaxy']));
    }

    public function test_make_from_collection()
    {
        $locations = (new LocationFactory())->makeFromCollection(collect([
            $this->entity(['id' => 1]),
            $this->entity(['id' => 2, 'type' => 'city']),
        ]));

        $this->assertCount(2, $locations);
        $this->assertContainsOnlyInstancesOf(Location::class, $locations);
        $this->assertSame([1, 2], $locations->pluck('id')->all());
        $this->assertSame(LocationType::CITY, $locations[1]->type);
    }

    public function test_make_from_empty_collection()
    {
        $this->assertTrue((new LocationFactory())->makeFromCollection(collect())->isEmpty());
    }
}
