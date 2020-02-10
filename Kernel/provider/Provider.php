<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/20
 * Time: 11:58
 */
namespace Kernel\provider;

class Provider
{
    public $app;

    // 延迟加载
    public $defer = false;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function isDeferred()
    {
        return $this->defer;
    }

    public function provides()
    {
        return [];
    }
}