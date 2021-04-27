<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Limits
    |--------------------------------------------------------------------------
    |
    | These options allow you to limit the data shown on the search results.
    |
    */
    'limits' => [
        'recent' => 4,
    ],

    'cookie' => [
        'name' => 'recent_searches',
        'time' => 2629746, // 5 years (minutes)
    ],

    // define the result cache
    'cache_hours' => 24, // hours
];
