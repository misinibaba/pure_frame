<?php

namespace bootstrap\base;

use bootstrap\facades\Facade;
use Kernel\Application;

class RegisterFacades
{
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);
    }
}
