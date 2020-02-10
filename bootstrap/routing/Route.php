<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/3/25
 * Time: 15:28
 */
namespace bootstrap\routing;

use Kernel\Http\foundation\Response;
use Kernel\Http\Request;
use Kernel\Ioc;

class Route
{
    protected $methods;
    protected $uri;
    protected $action;
    protected $router;
    protected $container;
    protected $controller;
    protected $parameters = [];

    public function __construct($methods, $uri, $action)
    {
        $this->uri     = $uri;
        $this->methods = (array) $methods;
        $this->action  = $action;

        if (in_array('GET', $this->methods) && ! in_array('HEAD', $this->methods)) {
            $this->methods[] = 'HEAD';
        }
    }

    public function run()
    {
        $method = $this->getControllerMethod();
        $controller = $this->getController();

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($method, $this->parameters);
        }

        return call_user_func_array([$controller, $method], $this->parameters);
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

    public function setContainer(Ioc $container)
    {
        $this->container = $container;

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function methods()
    {
        return $this->methods;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getController()
    {
        list($class) = explode('@', $this->action['uses']);

        if (! $this->controller) {
            $this->controller = $this->container->get($class);
        }

        return $this->controller;
    }

    protected function getControllerMethod()
    {
        return explode('@', $this->action['uses'])[1];
    }

    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function getParameters($name, $default = null)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }


}