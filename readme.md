# Simple API Laravel 5

Simple demo of a Laravel API, using Dingo and JWT for authentication.


----------


## Package Included
1. [Laravel Ide Helper](https://github.com/barryvdh/laravel-ide-helper)
2. [Jwt Auth](https://github.com/tymondesigns/jwt-auth)
3. [Dingo](https://github.com/dingo/api)

----------

## Pre-Install
```
brew install php56-memcached
```

## Installation

### Step 1: Clone the repo
```
git clone https://github.com/avew/simple-api-with-laravel5
```

### Step 2: Prerequisites
```
composer install
cp .env.example .env   
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan jwt:generate

```

### Step 3: Run
```
php artisan serve
```


----------
### Test With Postman

Import collection test in folder 
```postman/simple-api-with-laravel5.json```
### Generate API Doc
```
php artisan api:generate --router="dingo" --routePrefix="v1"
```
