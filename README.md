# LIT Timetables
[![Build Status](https://travis-ci.com/marky291/lit-timetables.svg?token=rSzsJZBSMZpGe42pERU9&branch=main)](https://travis-ci.com/marky291/lit-timetables)
[![Latest Version](https://img.shields.io/github/v/release/marky291/lit-timetable.svg?style=flat-square)](https://github.com/marky291/lit-timetable/releases)

## Installation

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

Seed the database for local development and search
```
$ ./vendor/bin/sail artisan db:seed
```

Or use live timetable data for testing
```
$ ./vendor/bin/sail artisan scrape:week {week_number}
```

## Testing

``` bash
$ ./vendor/bin/sail test
```

## Security
If you discover a security vulnerability please send an e-mail to Mark Hester via [marky360@live.ie](mailto:marky360@live.ie).

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
