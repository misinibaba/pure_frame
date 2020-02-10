<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/21
 * Time: 13:14
 */
namespace Kernel;

use bootstrap\routing\Router;
use Kernel\Http\Request;

class Kernel
{
    protected $app;
    protected $router;

    /**
     * @var array 在http调用中需要加载的数组
     */
    public $bootstrapList = [
        \bootstrap\base\LoadConfiguration::class,  // 加载配置
        \bootstrap\base\RegisterFacades::class,    // 加载facade
        \Kernel\provider\RegisterProviders::class, // 注册cofig.app里的provider
        \Kernel\provider\BootProviders::class,     //
    ];

    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    public function handle(Request $request)
    {
        $this->app->instance('request', $request);

        $this->bootstrap();

        return $this->dispatchToRouter($request);
    }

    public function bootstrap()
    {
        if (!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrapList);
        }
    }

    public function dispatchToRouter($request)
    {
        return $this->router->findRoute($request);
    }
}