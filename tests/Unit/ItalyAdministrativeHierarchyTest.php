<?php


use TheCoder\World\Facades\World;
use TheCoder\World\Tests\TestCase;

class ItalyAdministrativeHierarchyTest extends TestCase
{
    // Official ISTAT regions (15 ordinary + 5 autonomous), per
    // https://www.istat.it/classificazione/codici-dei-comuni-delle-province-e-delle-regioni/
    //
    // Aosta Valley is intentionally excluded: in the upstream dr5hn dataset it
    // has no child province, because it is the one Italian region that is
    // also a single province in its own right - there is no separate tier
    // to recover for it from the source data.
    private const ISTAT_REGIONS = [
        'Abruzzo', 'Apulia', 'Basilicata', 'Calabria', 'Campania',
        'Emilia-Romagna', 'Lazio', 'Liguria', 'Lombardy', 'Marche',
        'Molise', 'Piedmont', 'Tuscany', 'Umbria', 'Veneto',
        'Friuli–Venezia Giulia', 'Sardinia', 'Sicily', 'Trentino-South Tyrol',
    ];

    public function test_italy_has_19_istat_regions()
    {
        $regions = World::countries('Italy')->regions()->get();

        $this->assertEquals(
            count(self::ISTAT_REGIONS),
            $regions->count(),
            'Italy should expose its ISTAT regions via World::countries(\'Italy\')->regions()'
        );
    }

    public function test_barletta_andria_trani_is_a_province_not_a_region()
    {
        $region = World::regions('Barletta-Andria-Trani')->first();

        $this->assertNull(
            $region,
            'Barletta-Andria-Trani is a province (per ISTAT), it must not be classified as a region'
        );
    }

    public function test_ravenna_is_a_province_not_a_region()
    {
        $region = World::regions('Ravenna')->first();

        $this->assertNull(
            $region,
            'Ravenna is a province (per ISTAT), it must not be classified as a region'
        );
    }

    public function test_abruzzo_region_has_its_provinces()
    {
        $provinces = World::regions('Abruzzo')->provinces()->get();

        // Per ISTAT, Abruzzo region contains 4 provinces: Chieti, L'Aquila, Pescara, Teramo
        $this->assertEquals(4, $provinces->count());
    }
}
