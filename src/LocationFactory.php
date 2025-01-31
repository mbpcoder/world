<?php

namespace TheCoder\World;

use Illuminate\Support\Collection;
use TheCoder\World\Spatial\Point;

class LocationFactory
{
    public function make(\stdClass $entity): Location
    {
        $location = new Location();

        $location->id = $entity->id ?? null;
        $location->continentId = $entity->continent_id ?? null;
        $location->countryId = $entity->country_id ?? null;
        $location->provinceId = $entity->province_id ?? null;
        $location->isoCode = $entity->iso_code ?? null;
        $location->type = LocationType::from($entity->type);
        $location->nativeName = $entity->native_name ?? null;
        $location->englishName = $entity->english_name ?? null;
        $location->timezone = $entity->timezone ?? null;
        $location->isCapital = $entity->is_capital === 1;
        $point = new Point();
        if ($entity->center !== null) {
            str_contains(strtolower($entity->center), 'point') ? $point->parse($entity->center) : $point->parseBinary($entity->center);
        }
        $location->center = $point;
        $location->area = $entity->area ?? null;
        $location->priority = $entity->priority ?? null;
        return $location;
    }

    public function makeFromCollection(Collection $entities)
    {
        $entityCollection = collect();

        foreach ($entities as $entity) {
            $entityCollection->push($this->make($entity));
        }

        return $entityCollection;
    }
}