<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Installation

Type in the following commands:


Install the composer
```php
composer install
```


Install npm
```php
npm install
```

Copy the contents from .env.example into your .env and replace the DB_DATABASE, DB_USERNAME and DB_PASSWORD with your mysql credentials.
```php
DB_DATABASE=mini_hotel_app
DB_USERNAME=root
DB_PASSWORD=
```


Clear Laravel config cache 
```php
php artisan config:cache
```


Generate Laravel Key 
```php
php artisan key:generate
```


Generate mysql database and fill it with dummy data
```php
php artisan migrate:fresh --seed
```
