# LIT Timetables
![Laravel](https://github.com/marky291/lit-timetables/workflows/Laravel/badge.svg)
[![Latest Version](https://img.shields.io/github/v/release/marky291/lit-timetables.svg?style=flat-square)](https://github.com/marky291/lit-timetables/releases)

## Installation

[Git](https://git-scm.com/) pull this repository to a location of choice on your computer.
```
git clone https://github.com/marky291/lit-timetables.git
```

Download and use [Composer](https://getcomposer.org/), in the root of the project.

#### Composer Installation (Linux & MacOS)
``` bash
composer install
```

#### Composer installation (Windows)
``` bash
composer install --ignore-platform-reqs
```

Seed the database for local development
```
./vendor/bin/sail artisan db:seed
```

Or use live timetable data for testing
```
./vendor/bin/sail artisan sync:week
```

## Docker (Linux & MacOS)
Deploy the [Laravel Docker Container](https://laravel.com/docs/8.x/sail) for environment setup.
If you are missing docker then you should install [Docker](https://docs.docker.com/engine/install/)
```
./vendor/bin/sail up
```

## MeiliSearch
Meilisearch is an open-source search engine that powers the search in the application by default this is preconfigured with the laravel sail docker container and defined in the `.env` environment file.

#### MeiliSearch Installation (Linux & MacOS)
```sh
SCOUT_DRIVER=meiliesearch
SCOUT_QUEUE=true
```

#### MeiliSearch Installation (Windows)
```sh
SCOUT_DRIVER=mysql
SCOUT_QUEUE=false
```

Meiliesearch uses [Laravel Scout](https://laravel.com/docs/8.x/scout) as the engine driver.

## Testing

``` bash
php artisan test
```

## Security
If you discover a security vulnerability please send an e-mail to Mark Hester via [marky360@live.ie](mailto:marky360@live.ie).

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
