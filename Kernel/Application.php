<?php
namespace Kernel;
use Kernel\provider\RoutingProvider;

class Application extends Ioc
{
    protected $hasBeenBootstrapped = false;

    public $deferredServices = [];

    public $loadedProviders = [];

    public $serviceProviders = [];

    public function __construct()
    {
        $this->init();
    }

    /**
     * 初始化数据
     */
    public function init()
    {
        $this->instance('app', $this);

        // 绑定初始provider
        $this->register(new RoutingProvider($this));

        // 绑定初始别名类
        $this->bindCoreAlias();
    }

    /**
     * 调用函数中的register方法
     * @param $provider object 一般是个闭包函数
     * @return mixed
     */
    public function register($provider)
    {
        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $class = get_class($provider);

        // 将已经注册好的provider放入数组
        if (!isset($this->loadedProviders[$class])) {
            $this->serviceProviders[] = $provider;
        }

        $this->loadedProviders[$class] = true;

        return $provider;
    }

    // 调用每一个注册好的service的boot方法，一般用来初始化该service依赖的数据
    public function boot()
    {
        array_walk($this->serviceProviders, function ($provider) {
            if (method_exists($provider, 'boot')) {
                return $provider->boot();
            }
        });
    }

    public function configPath()
    {
        return ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    }

    // 加载框架初始加载项
    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;
        foreach ($bootstrappers as $bootstrapper) {
            $this->get($bootstrapper)->bootstrap($this);
        }
    }

    public function hasBeenBootstrapped()
    {
        return $this->hasBeenBootstrapped;
    }

    /**
     * 绑定初始别名
     */
    public function bindCoreAlias()
    {
        $aliases = [
            'app'      =>  ['Kernel\Application'],
            'router'   =>  ['bootstrap\routing\Router'],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->aliases[$alias] = $key;
            }
        }
    }

    // 注册初始provider
    public function registerConfiguredProviders()
    {
        $providers = $this->config['app.providers'];

        foreach ($providers as $provider) {
            $instance = new $provider($this);

            // 如果时延迟加载
            $manifest['deferred'] = [];
            if ($instance->isDeferred()) {
                foreach ($instance->provides() as $service) {
                    $manifest['deferred'][$service] = $provider;
                }
            } else {
                // 否则
                $manifest['eager'][] = $provider;
            }
        }

        // 加载非延迟加载的provider
        foreach ($manifest['eager'] as $provider) {
            $this->register(new $provider($this));
        }

        // 延迟加载的项目放入数组
        $this->deferredServices = array_merge($this->deferredServices, $manifest['deferred']);
    }
}