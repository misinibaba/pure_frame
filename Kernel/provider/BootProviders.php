<?php

namespace Kernel\provider;

use Kernel\Application;

class BootProviders
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
