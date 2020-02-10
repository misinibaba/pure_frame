<?php
namespace Kernel\provider;

use Illuminate\Database\Capsule\Manager;

/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:35
 */
class EloquentProvider extends Provider
{
    public function register()
    {
        $this->app->single('eloquent', function () {
            return new Manager();
        }, false);
    }

    public function boot()
    {
        $this->app->get('eloquent')->addConnection($this->app['config']['database.eloquent']);
        $this->app->get('eloquent')->setAsGlobal();
        $this->app->get('eloquent')->bootEloquent();
    }
}