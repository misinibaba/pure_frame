<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/3/25
 * Time: 15:28
 */
namespace bootstrap\routing;

use Http\Request;

class RouteCollection
{
    public $routes = [];
    public $allRoutes = [];
    public $nameList = [];
    public $actionList = [];

    public function add(Route $route)
    {
        $this->addToCollections($route);

        $this->addLookups($route);

        return $route;
    }

    protected function addToCollections(Route $route)
    {
        $domainAndUri = $route->getUri();

        foreach ($route->methods() as $method) {
            $this->routes[$method][$domainAndUri] = $route;
        }

        $this->allRoutes[$method.$domainAndUri] = $route;
    }

    protected function addLookups(Route $route)
    {
        $action = $route->getAction();

        if (isset($action['controller'])) {
            $this->actionList[trim($action['controller'], '\\')] = $route;
        }
    }

    public function match($request)
    {
        // 先找到请求method下所有路由
        $matchRoutes = $this->routes[$request->getMethod()];
        $routeUris = array_keys($matchRoutes);
        $requestUri = $request->server->getRequestUri(false);
        $requestUri = rtrim($requestUri, '/');

        // 参数
        $parameters = [];

        // 然后匹配uri
        $matchRoute = '';
        $requestUriArr = explode('/', $requestUri);
        foreach ($routeUris as $routeUri) {
            $routeUriArr = explode('/', $routeUri);
            if (count($routeUriArr) != count($requestUriArr)) {
                continue;
            }

            $count = count($routeUriArr);
            $matched = true;
            for ($i = 0; $i < $count; $i++) {
                if (strpos($routeUriArr[$i], '{') !== false) {
                    $parameterKey = rtrim($routeUriArr[$i], '}');
                    $parameterKey = ltrim($parameterKey, '{');
                    $parameters[$parameterKey] = $requestUriArr[$i];
                    continue;
                }

                if ($requestUriArr[$i] != $routeUriArr[$i]) {
                    $matched = false;
                    $parameters = [];
                    break;
                }
            }
            if ($matched === true) {
                $matchRoute = $matchRoutes[$routeUri];
                break;
            }
        }

        if ($matchRoute) {
            $matchRoute->setParameter('request', $request);
            foreach ($parameters as $key => $value) {
                $matchRoute->setParameter($key, $value);
            }
            return $matchRoute;
        } else {
            throw new \Exception('没匹配到路由');
        }
    }
}