# World - PHP and Laravel Package for Continents, Countries, Provinces, and Cities

## Overview
World is a powerful PHP package that provides structured data for continents, countries, provinces, and cities.

Easily retrieve geographical data using simple queries. Ideal for Laravel and PHP applications needing world geography data.

## Features
  * Retrieve all continents and countries.
  * Filter countries by continent.
  * Get provinces and cities for any country.
  * Lightweight and optimized for performance.
  * Fully compatible with Laravel and PHP applications.
  * PHP Country list
  * Get all country list
  * Get all cities as array
  * Gte country from city


## Installation
Install via [Composer](https://getcomposer.org):

```bash
composer require thecoder/world
```

After installation, add the service provider to your config/app.php providers array (if auto-discovery is not working):

```php
TheCoder\World\WorldServiceProvider::class,

```
### Publish Configuration and Migrations
To publish the configuration and migrations, run the following Artisan command:
```php
php artisan vendor:publish --provider="TheCoder\World\WorldServiceProvider"
```
This will publish:
 * ``` config/world.php ``` file.
 * Migration files to the ``` database/migrations ```  directory.

### Migrate the Database
To create the necessary database tables, run the migration command:
```bash
php artisan migrate
```
### Seed the Database
You can also seed the database with initial data by running:
```bash
php artisan world:seed
```
This command will seed the ``` locations ``` table with predefined geographic data.

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


### Database Schema
The ``` locations ``` table is designed to store hierarchical geographic data for various types of locations, such as continents, countries, provinces, regions, and cities. The table includes essential details about each location, including its name, type, timezone, and geographical coordinates. Additionally, it supports a flexible structure that allows for nesting locations within other locations (e.g., provinces within countries, cities within provinces).

#### Table Structure

 * id: The primary key for the location record.
 * continent_id: A foreign key referencing the parent location if the location is part of a continent. This column can be null for top-level locations like countries.
 * country_id: A foreign key referencing the parent location if the location is part of a country. This column can be null for top-level locations like regions.
 * province_id: A foreign key referencing the parent location if the location is part of a province. This column can be null for top-level locations like cities.
 * iso_code: A 3-character ISO code for the location (e.g., "IR" for Iran). This field is indexed for quick lookups.
 * type: An enum defining the type of location: 'continent', 'country', 'region', 'province', or 'city'. This field is indexed to improve query performance when filtering by type.
 * native_name: The native name of the location (optional). For example, the name in the local language.
 * english_name: The English name of the location (required).
 * timezone: The timezone of the location (e.g., "Asia/Tehran"). This field can be null if not specified.
 * is_capital: A boolean flag indicating whether the location is a capital city (default: false).
 * priority: An integer value that can be used to determine the priority or relevance of the location (default: 0).
 * created_at: The timestamp when the location record was created.
 * updated_at: The timestamp when the location record was last updated.

 #### Spatial Data
 * center: A spatial column of type ``` POINT ```, used to store the geographic coordinates (latitude and longitude) of the location's center.
 * area: A spatial column of type ``` MULTIPOLYGON ```, used to store the geographic boundaries of the location. This is useful for representing regions, countries, or cities with complex borders.

#### Foreign Keys
 * continent_id: References the id of the parent continent if the location is a part of one.
 * country_id: References the id of the parent country if the location is a part of one.
 * province_id: References the id of the parent province or region if the location is a part of one.

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
