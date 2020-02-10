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

class Router
{
    public $currentRequest;
    public $container;
    public $routes;

    public function __construct(Ioc $container = null)
    {
        $this->routes = new RouteCollection;
        $this->container = $container ?: new Ioc;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function get($uri, $action)
    {
        return $this->addRoute(['GET', 'HEAD'], $uri, $action);
    }

    public function post($uri, $action = null)
    {
        return $this->addRoute('POST', $uri, $action);
    }

    public function addRoute($methods, $uri, $action)
    {
        return $this->routes->add($this->createRoute($methods, $uri, $action));
    }

    protected function createRoute($methods, $uri, $action)
    {
        $action = 'Http\\controller\\' . $action;
        $action = ['uses' => $action];
        $action['controller'] = $action['uses'];

        $route = $this->newRoute(
            $methods, $uri, $action
        );

        return $route;
    }

    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }

    public function findRoute($request)
    {
        $route = $this->routes->match($request);
        $res = $route->run();

        if (!$res instanceof Response) {
            $res = new Response((string)$res);
        }
        return $res;
    }


}