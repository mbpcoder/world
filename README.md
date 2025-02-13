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
Install via [Composer](https://getcomposer.org):

```bash
composer require thecoder/world
```

## Usage

### Basic Example

``` php
use TheCoder\World;

$world = new World();

$continents = $world->continents()->get();  // Get all continents
$countries = $world->countries()->get();  // Get all countries
```

### Get Data by Continent

```php
$asia = $world->continents()->whereEnglishNameEqual('Asia')->get();  // Get Asia continent
$asiaCountries = $world->continents()->whereEnglishNameEqual('Asia')->countries()->get();  // Get Asia countries
$asiaCountries = $world->continents()->whereIdEqual(1)->countries()->get();  // Get Asia countries by ID

```

### Get Provinces and Cities

```php
$iranProvinces = $world->countries()->whereEnglishNameEqual('Iran')->provinces()->get();  // Get Iran provinces

gilanProvinceCities = $world->provinces()->whereEnglishNameEqual('Gilan')->cities()->get();  // Get cities in Gilan province
```

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
### What is this package used for?
This package helps developers retrieve geographical data such as continents, countries, provinces, and cities for use in PHP and Laravel applications.

### Is this package compatible with Laravel?
Yes, it works seamlessly with Laravel and vanilla PHP projects.

### How can I filter countries by continent?
You can filter countries using:
```php
$world->continents()->whereEnglishNameEqual('Europe')->countries()->get();
```

### Can I get cities of a specific province?
Yes, use:
```php
$world->provinces()->whereEnglishNameEqual('California')->cities()->get();
```
## Contributing
Contributions are welcome! Feel free to submit issues or pull requests.

## License
This package is open-source and available under the [MIT License](https://en.wikipedia.org/wiki/MIT_License).
