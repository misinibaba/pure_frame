<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/1
 * Time: 17:11
 */
namespace bootstrap\facades;

abstract class Facade
{
    protected static $app;

    protected static $resolvedInstance;

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new \Exception('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    protected static function getFacadeAccessor()
    {
        throw new \Exception('Facade does not implement getFacadeAccessor method.');
    }

    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$app[$name];
    }

    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }

    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }
}