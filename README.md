# 🌍 World - PHP & Laravel Package for Geographical Data

**World** is a powerful PHP and Laravel package for retrieving structured geographical data, including **continents, countries, provinces, and cities**. This package is lightweight, optimized for performance, and seamlessly integrates with Laravel applications.

---

## 🚀 Features

✔ Get all **continents, countries, provinces, and cities**  
✔ Filter countries by continent  
✔ Retrieve provinces and cities for any country  
✔ Optimized for **high performance** with caching  
✔ Compatible with **Laravel and PHP**  
✔ Includes **migrations and seeding** for easy setup  
✔ includes a Laravel Facade for simpler usage!

---

## 📦 Installation

Install via Composer:

```sh
composer require thecoder/world
```

If auto-discovery is not working, manually add the service provider in `config/app.php`:

```php
TheCoder\World\WorldServiceProvider::class,
```

### 🔧 Publish Configuration & Migrations for Greater Flexibility

```sh
php artisan vendor:publish --provider="TheCoder\World\WorldServiceProvider"
```

This will publish:  
✅ `config/world.php` (configuration file)  
✅ Database migration files

### 🛠 Migrate the Database

```sh
php artisan migrate
```

### 🌍 Seed Geographical Data

```sh
php artisan world:seed
```

This will populate the database with continents, countries, provinces, and cities.

The data is downloaded once from [`dr5hn/countries-states-cities-database`](https://github.com/dr5hn/countries-states-cities-database) and cached locally in `database/seeders/countries+states+cities.json`. Re-running `world:seed` upserts records by a stable `source_id`, so existing rows keep their `id` — safe to run again after the upstream data changes.

To pull the latest upstream data instead of reusing the local cache:

```sh
php artisan world:seed --fresh-data
```

---

## 🔍 Usage

### 1️⃣ Using the Built-in World Facade (Recommended)

The package now includes a **World** Facade, making it easier to access data:

```php
use World;

$continents = World::continents()->get();  // Get all continents
$countries = World::countries()->get();  // Get all countries
```

### 2️⃣ Manually Instantiate the Class

```php
use TheCoder\World;

$world = new World();

$continents = $world->continents()->get();  
$countries = $world->countries()->get();  
```

### Get Locations

```php
$location = World::byId(1)->first();

$location = World::byEnglishName('Asia')->first();

$locations = World::byIds([1,2])->get();

$locations = World::byEnglishNames(['Iraq', 'Iran'])->get();

$location = World::count();  
```

### Get Countries by Continent

```php
$asia = World::continents('Asia')->first();

$asia = World::continents()->byEnglishName('Asia')->first();  

$asiaCountries = World::continents()->byEnglishName('Asia')->countries()->get();  
```

### Get Provinces & Cities

```php
$iranProvinces = World::countries('Iran')->provinces()->get();

$iranProvinces = World::countries()->byEnglishName('Iran')->provinces()->get();

$gilanCities = World::provinces('Gilan')->cities()->get();  
  
$gilanCities = World::provinces()->byEnglishName('Gilan')->cities()->get();  
```

---

## ⚡Caching for Maximum Performance
Since the World database is static and never changes, this package supports permanent caching to eliminate redundant database queries and significantly improve performance.

### Enable Caching
You can enable caching in the ``` config/world.php ``` file:
```php
  'cache' => [
      'enabled' => true,
      'prefix' => 'thecoder-world-',
      'tag' => 'thecoder-world',
      'ttl' => null, // Store cache forever
  ],
```
Setting ttl to null ensures that data is cached forever.

### Use Cached Data in Queries
If caching is enabled, queries will automatically store results in the cache forever.

### Manually Clear Cache (If Needed)
To clear the cache manually, run:
```bash
  php artisan cache:clear
```
Or in code:
```php
World::clearCache();
```

---
## 🏗 Package-Integrated Laravel Facade

The package now provides a **World** Facade out-of-the-box, meaning Laravel users **don't need to set it up manually**.

✔ **No need to register aliases**  
✔ **Works automatically in Laravel**

Just install the package and start using it:

```php
use World;

$continents = World::continents()->get();
```

---

## 🧪Testing
Ensure you have the necessary dependencies installed:
```bash
composer install --dev
```
### ⚠️ Database Configuration for Testing
Due to special columns in the database, SQLite is not supported for testing.

Instead, configure MySQL in phpunit.xml:

```xml
    <php>
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_HOST" value="127.0.0.1"/>
        <env name="DB_PORT" value="3306"/>
        <env name="DB_DATABASE" value="world_test_database"/>
        <env name="DB_USERNAME" value="root"/>
        <env name="DB_PASSWORD" value=""/>
    </php>
```

### ▶️ Running tests
```bash
vendor/bin/phpunit
```

## 🗄 Database Schema

This package provides a **locations table** designed to store structured geographic data with hierarchical relationships.

| Column       | Type        | Description |
|-------------|------------|-------------|
| `id`        | Integer (PK) | Unique identifier |
| `continent_id` | Integer (FK) | Parent continent (nullable) |
| `country_id` | Integer (FK) | Parent country (nullable) |
| `province_id` | Integer (FK) | Parent province (nullable) |
| `iso_code`  | String (3) | ISO country code (e.g., "US") |
| `type`      | Enum | `continent`, `country`, `province`, `city` |
| `english_name` | String | Location name in English |
| `native_name` | String | Local name (optional) |
| `timezone`  | String | Time zone (e.g., "Asia/Tehran") |
| `is_capital` | Boolean | Marks capital cities (default: false) |
| `priority`  | Integer | Sort priority (default: 0) |
| `center`    | POINT | Geographic coordinates |
| `area`      | MULTIPOLYGON | Spatial data for regions |

✅ **Indexed for fast queries**  
✅ **Supports geographic coordinates & boundaries**

---

## ❓ FAQ

### 🔹 What is this package used for?
It helps developers retrieve geographical data (continents, countries, provinces, and cities) for Laravel & PHP applications.

### 🔹 Is this package compatible with Laravel?
Yes! It fully supports Laravel and can also be used in vanilla PHP projects.

### 🔹 How can I filter countries by continent?

```php
World::continents('Europe')->countries()->get();
```

### 🔹 Can I get cities of a specific province?

```php
World::provinces('California')->cities()->get();
```

---

## ⭐ Contribute & Support

🔹 **GitHub Repository:** [thecoder/world](https://github.com/thecoder/world)  
🔹 **Issues & Features:** [Submit Here](https://github.com/thecoder/world/issues)  
🔹 **Contribute:** Fork, star ⭐, and submit PRs

💡 **Need more features?** Open an issue or contribute to the project!  
