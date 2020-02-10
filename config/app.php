<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:42
 */
return [
    'timezone' => 'Asia/Shanghai',
    'debug'    => true,
    'xhprof'   => false,
    'xhprof_path'   => '/var/www/html/xhprof',
    'xhprof_url'    => 'http://localhost/xhprof',
    'redis_ttl'     => 60,

    // blade
    'cache_path' => ROOT_PATH . 'cache/views',
    'view_path'  => ROOT_PATH . 'resources/views',

    // 按kernel加载
    'providers' => [
        \Kernel\provider\MysqlProvider::class,
        \Kernel\provider\RedisProvider::class,
        \Kernel\provider\EloquentProvider::class,
        \Kernel\provider\BladeProvider::class,
    ]
];