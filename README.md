# 🌍 World - PHP & Laravel Package for Geographical Data

**World** is a powerful PHP and Laravel package for retrieving structured geographical data, including **continents, countries, provinces, and cities**. This package is lightweight, optimized for performance, and seamlessly integrates with Laravel applications.

---

## 🚀 Features

✔ Get all **continents, countries, provinces, and cities**  
✔ Filter countries by continent  
✔ Retrieve provinces and cities for any country  
✔ Optimized for **high performance**  
✔ Compatible with **Laravel and PHP**  
✔ Includes **migrations and seeding** for easy setup

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

### 🔧 Publish Configuration & Migrations

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

---

## 🔍 Usage

### Retrieve All Continents & Countries

```php
use TheCoder\World;

$world = new World();

$continents = $world->continents()->get();  // Get all continents
$countries = $world->countries()->get();  // Get all countries
```

### Get Countries by Continent

```php
$asia = $world->continents()->whereEnglishNameEqual('Asia')->get();  
$asiaCountries = $world->continents()->whereEnglishNameEqual('Asia')->countries()->get();  
```

### Get Provinces & Cities

```php
$iranProvinces = $world->countries()->whereEnglishNameEqual('Iran')->provinces()->get();  
$gilanCities = $world->provinces()->whereEnglishNameEqual('Gilan')->cities()->get();  
```

---

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
$world->continents()->whereEnglishNameEqual('Europe')->countries()->get();
```

### 🔹 Can I get cities of a specific province?

```php
$world->provinces()->whereEnglishNameEqual('California')->cities()->get();
```

---

## ⭐ Contribute & Support

🔹 **GitHub Repository:** [thecoder/world](https://github.com/thecoder/world)  
🔹 **Issues & Features:** [Submit Here](https://github.com/thecoder/world/issues)  
🔹 **Contribute:** Fork, star ⭐, and submit PRs

💡 **Need more features?** Open an issue or contribute to the project!  
