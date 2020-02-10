<?php

namespace Kernel\provider;

use Kernel;
use Kernel\Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
