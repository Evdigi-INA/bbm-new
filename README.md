# BBM
Aplikasi Inventory menggunakan Laravel.

## What inside?
- Laravel ^8.x - [Laravel 8](https://laravel.com/docs/8.x)
- Laravel UI ^3.x - [Laravel/ui](https://github.com/laravel/ui/tree/3.x)
- Stara Admin Template

## Installation
Clone or download this repository
```shell
git clone https://github.com/msramdan/bbm
```

Install dependencies
```shell
# install laravel dependency
composer install
```

Generate app key, configure `.env` file and do migration.
```shell
# create copy of .env
cp .env.example .env

# create laravel key
php artisan key:generate

# setup database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbm
DB_USERNAME=root
DB_PASSWORD=

# migrate database
php artisan migrate

# start local development server
php artisan serve

```
