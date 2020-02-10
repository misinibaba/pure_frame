<?php
namespace Kernel\provider;

use component\Mysql;

/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:35
 */
class MysqlProvider extends Provider
{
    public function register()
    {
        $this->app->single('mysql', function ($app) {
            return new Mysql($app['config']['database.mysql']);
        }, false);
    }
}