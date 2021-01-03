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

Deploy the [Laravel Docker Container](https://laravel.com/docs/8.x/sail) to run locally
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

## MeiliSearch
Meilisearch is an open-source search engine that requires a seperate service to run in the background, if you do not wish to use mysql as the test engine and would rather recreate the live environment, Currently this only supports mac and ubuntu installations. This is a client and server service.

Modify your `.env` file and alter the following configurations, to enable client side.

```sh
$ SCOUT_DRIVER=meiliesearch
$ SCOUT_QUEUE=true
```

Follow the documentation on meilisearch to install server side with tool of choice.
https://docs.meilisearch.com/guides/advanced_guides/installation.html#download-and-launch

The engine used on the client side for interaction against server is Laravel Scout.
Laravel scout will automatically track and alter server based on model observation.
https://laravel.com/docs/8.x/scout

You can manually use commands to pertain certain actions if required.
| Action | Command |
| ------ | ------ |
| Import | php artisan scout:import "App\Models\\{Model}" |
| Flush | php artisan scout:flush "App\Models\\{Model}" |

## Testing

``` bash
$ php artisan test
```

## Security
If you discover a security vulnerability please send an e-mail to Mark Hester via [marky360@live.ie](mailto:marky360@live.ie).

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
