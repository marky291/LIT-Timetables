# LIT Timetables
![Laravel](https://github.com/marky291/lit-timetables/workflows/Laravel/badge.svg)
[![Latest Version](https://img.shields.io/github/v/release/marky291/lit-timetable.svg?style=flat-square)](https://github.com/marky291/lit-timetable/releases)

## Installation on Mac & Linux

[Git](https://git-scm.com/) pull this repository to a location of choice on your computer.
```
$ git clone https://github.com/marky291/lit-timetables.git
```

Download and use [Composer](https://getcomposer.org/), in the root of the project.

``` bash
$ composer install
```

Deploy the [Laravel Docker Container](https://laravel.com/docs/8.x/sail) for environment setup.
If you are missing docker then you should install [Docker](https://docs.docker.com/engine/install/)
```
$ ./vendor/bin/sail up
```

Seed the database for local development
```
$ ./vendor/bin/sail artisan db:seed
```

Or use live timetable data for testing
```
$ ./vendor/bin/sail artisan scrape:week {week_number}
```

## Installation on Windows

Laravel sail support MacOS, Linux and Windows (WSL2)
https://www.omgubuntu.co.uk/how-to-install-wsl2-on-windows-10

Using WSL2 on windows you can now follow the installation for linux operating systems.

## MeiliSearch
Meilisearch is an open-source search engine that powers the search in the application by default this is preconfigured with the laravel sail docker container and defined in the `.env` environment file.

```sh
$ SCOUT_DRIVER=meiliesearch
$ SCOUT_QUEUE=true
```

[Laravel Scout](https://laravel.com/docs/8.x/scout) is the engine driver that allows automatic synchronization of the application models.
For more information on library usage you can check out the [laravel documentation](https://laravel.com/docs/8.x/scout).

## Testing

``` bash
$ php artisan test
```

## Security
If you discover a security vulnerability please send an e-mail to Mark Hester via [marky360@live.ie](mailto:marky360@live.ie).

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
