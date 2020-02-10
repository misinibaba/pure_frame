<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/20
 * Time: 14:33
 */
namespace component;

use bootstrap\facades\Config;

class Redis
{
    public $config;
    public static $redis;

    public function __construct($config)
    {
        $this->config = $config;
        self::$redis = new \Redis();
        self::$redis->connect($config['default']['host'], $config['default']['port']);
        if (!empty($config['default']['password'])) {
            self::$redis->auth($config['default']['password']);
        }
    }

    public static function get($key)
    {
        if (! self::$redis instanceof \Redis) {
            new static(Config::get('database.redis'));
        }
        return self::$redis->get($key);
    }

    public static function set($key, $value, $timeout = 0)
    {
        if (! self::$redis instanceof \Redis) {
            new static(Config::get('database.redis'));
        }

        return self::$redis->set($key, $value, $timeout);
    }

    public static function setex($key, $ttl, $value)
    {
        if (! self::$redis instanceof \Redis) {
            new static(Config::get('database.redis'));
        }
        return self::$redis->setex($key, $ttl, $value);
    }

    public static function hgetall($key)
    {
        if (! self::$redis instanceof \Redis) {
            new static(Config::get('database.redis'));
        }
        return self::$redis->hGetAll($key);
    }

    public function __call($name, $arguments)
    {
        if (! self::$redis instanceof \Redis) {
            new static(Config::get('database.redis'));
        }

        if (method_exists(self::$redis, $name)) {
            return call_user_func_array(array(self::$redis, $name), $arguments);
        } else {
            throw new \Exception('无效的redis方法：' . $name);
        }
    }
}