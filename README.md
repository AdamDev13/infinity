# InfinityComm

## Built with Love at UglyDuckMarketing


# Development Environment

## Install php and composer

`curl -sS https://getcomposer.org/installer | php`

`php composer.phar update`
`php composer.phar install`

## Copy .env file from example

`cp .env.example .env`

## Using Devcontainers (Docker)

`php artisan sail:install --devcontainer`

Ref: https://laravel.com/docs/8.x/sail#using-devcontainers

## Start Sail

`./vendor/bin/sail up`

## Genarate keys

`php artisan key:generate`

## Migrate

`php artisan migrate`

## DB Seed

`php artisan db:seed`

# Deployment

## Git pull

`git pull origin develop`

## Update composer

`composer update`

## Refresh cache

`php artisan config:clear`
`php artisan route:clear`
`php artisan view:clear`

or 

`php artisan nova:publish`

## Correct owner

`chown <username>:nobody -R ./`

`chown bigideas:nobody -R ./`