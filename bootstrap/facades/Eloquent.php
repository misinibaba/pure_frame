<?php

namespace bootstrap\facades;

class Eloquent extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eloquent';
    }
}
