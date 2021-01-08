<?php

return [
    'url' => [
        'base' => 'http://timetable.lit.ie:8080',
        'filter' => 'http://timetable.lit.ie:8080/js/filter.js',
        'source' => 'http://timetable.lit.ie:8080/reporting/individual;student+set;id;%s?t=student+set+individual&template=student+set+individual%s',
    ],

    'semester' => [
        'first' => [
            'start' => '31 August',
            'end' => '14 December',
        ],
        'second' => [
            'start' => '11 January',
            'end' =>'10 May',
        ],
    ],

    'day_position' => [
        'mon' => 0,
        'tue' => 1,
        'wed' => 2,
        'thu' => 3,
        'fri' => 4,
        'sat' => 5,
        'sun' => 6,
    ],

    'time' => [
        'starting_hour' => 8,
        'increment_minutes' => 30,
    ],
];
