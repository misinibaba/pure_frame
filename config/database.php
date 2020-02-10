<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:43
 */
return [
    'default' => 'mysql',
    'mysql' => [
        'driver'   => 'mysql',
        'host'     => env('DB_HOST', ''),
        'database' => env('DB_DATABASE', ''),
        'username' => env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
        'charset'  => 'utf8',
        'default'  => 'mysql',
    ],
    'redis' => [
        'cluster' => false,
        'default' => [
            'host'          => env('REDIS_HOST', '127.0.0.1'),
            'password'      => env('REDIS_PASSWORD', null),
            'port'          => env('REDIS_PORT', '6379'),
            'database'      => 0
        ],
        'log_queue' => [
            'host'     => env('REDIS_QUEUE_HOST', '127.0.0.1'),
            'password' => env('REDIS_QUEUE_PASSWORD', null),
            'port'     => env('REDIS_QUEUE_PORT', 6379),
            'database' => 0,
        ],
    ],
    'eloquent' => [
        'driver'    => 'mysql',
        'host'      => env('DB_HOST', ''),
        'database'  => env('DB_DATABASE', ''),
        'username'  => env('DB_USERNAME', ''),
        'password'  => env('DB_PASSWORD', ''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ],
];