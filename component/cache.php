<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 11:41
 */
namespace component\cache;

class cache
{
    public $cache;

    public function __construct()
    {
    }

    public function set($name, $value)
    {
        $this->$name = $value;
    }
}