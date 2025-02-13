# World - PHP Package for Continents, Countries, Provinces, and Cities

## Overview
World is a powerful PHP package that provides structured data for continents, countries, provinces, and cities.

Easily retrieve geographical data using simple queries. Ideal for Laravel and PHP applications needing world geography data.

## Features
  * Retrieve all continents and countries.
  * Filter countries by continent.
  * Get provinces and cities for any country.
  * Lightweight and optimized for performance.
  * Fully compatible with Laravel and PHP applications.

## Installation
Install via Composer[https://getcomposer.org/]:

```bash
composer require thecoder/world
```

## Examples
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

## FAQ

