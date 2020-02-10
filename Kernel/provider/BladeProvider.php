<?php
namespace Kernel\provider;

use Philo\Blade\Blade;

/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 15:35
 */
class BladeProvider extends Provider
{
    public function register()
    {
        $this->app->single('blade', function () {
            return new Blade($this->app['config']['app.view_path'], $this->app['config']['app.cache_path']);
        }, false);
    }
}