# World


``` php

$world = new World();
$continents = $world->continents()->get();  // Get all continents
$countries = $world->countries()->get();  // Get all countries

$asia = $world->continents()->whereEnglishNameEqual('Asia')->get();  // Get Asia continent
$asiaCountries = $world->continents()->whereEnglishNameEqual('Asia')->countries()->get();  // Get Asia countries
$asiaCountries = $world->continents()->whereIdEqual(1)->countries()->get();  // Get Asia countries

$iranProvinces = $world->countries()->whereEnglishNameEqual('Iran')->provinces()->get();  // Get Iran provinces

$gilanProvinceCities = $world->provinces()->whereEnglishNameEqual('Gilan')->cities()->get();  // Get Gilan province cities

```
