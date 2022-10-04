<p align="center"><a href="#" target="_blank"><img src="https://i.pinimg.com/originals/8b/10/f8/8b10f8c55a472e0ccc85ee1e6453d31e.gif" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install/Update package

<!-- - [Simple, fast routing engine](https://laravel.com/docs/routing). -->
- composer update

## Copy .env.example to .env file

- cp .env.example .env

## Modify .env file

- ARCANEDEV_LOGVIEWER_MIDDLEWARE=web,auth
- LOG_CHANNEL=daily
- DB_DATABASE=<your_database>

- MAIL_MAILER=smtp
- MAIL_HOST=smtp.gmail.com
- MAIL_PORT=587
- MAIL_USERNAME=<your_email>
- MAIL_PASSWORD=<application_password_your_email>
- MAIL_ENCRYPTION=tls
- MAIL_FROM_ADDRESS=<your_email>

## Run migration

- php artisan key:generate
- php artisan migrate
- php artisan db:seed --class=DatabaseSeeder
- php artisan db:seed --class=PermissionSeeder
- php artisan serve

### GOOD LUCK

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
