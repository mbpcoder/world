<?php

namespace TheCoder\World;

class World
{
    private array $filters;

    public function continent(): self
    {
        $this->filters['type'] = LocationType::CONTINENT;
        return $this;
    }

    public function countries(): self
    {
        $this->filters['type'] = LocationType::COUNTRY;
        return $this;
    }

    public function provinces(): self
    {
        $this->filters['type'] = LocationType::PROVINCE;
        return $this;
    }

    public function states(): self
    {
        return $this->provinces();
    }

    public function cities(): self
    {
        $this->filters['type'] = LocationType::CITY;
        return $this;
    }

    public function getByEnglishName(string $englishName): Location
    {
        $this->filters['english_name'] = $englishName;
        $l = new Location();

        return $l;
    }

    public function getByNativeName(string $nativeName): Location
    {
        $l = new Location();

        return $l;
    }

    public function getById(int $id): Location
    {
        $l = new Location();

        return $l;
    }

    private function get(): array|Location
    {
        $query = $this->proccessFilter();
        $l = new Location();
        return $l;
    }

    private function proccessFilter(): string
    {
        foreach ($this->filters as $_filter) {

        }
        return '';
    }
}