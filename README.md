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
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
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


Run app on PHP development server
```php
php artisan serve
```
