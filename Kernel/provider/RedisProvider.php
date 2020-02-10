<?php
namespace Kernel\provider;

use component\Redis;

/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:35
 */
class RedisProvider extends Provider
{
    public function register()
    {
        $this->app->single('redis', function ($app) {
            return new Redis($app['config']['database.redis']);
        }, false);
    }
}