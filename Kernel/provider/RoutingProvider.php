<?php
namespace Kernel\provider;

use bootstrap\routing\Router;

class RoutingProvider extends Provider
{
    public function register()
    {
        $this->app->single('router', function ($app) {
            return new Router($app);
        });
    }


    public function boot()
    {
        require ROOT_PATH . DIRECTORY_SEPARATOR . 'routes/api.php';
    }
}