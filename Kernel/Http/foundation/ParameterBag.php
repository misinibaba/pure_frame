<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/3/25
 * Time: 13:23
 */
namespace Kernel\Http\foundation;

class ParameterBag
{
    public $parameters;

    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function all()
    {
        return $this->parameters;
    }

    public function getRequestUri($hasQueryString = true)
    {
        $requestUri = $this->get('REQUEST_URI');

        if (!$hasQueryString && !empty($this->get('QUERY_STRING'))) {
            return substr($requestUri, 0, strpos($requestUri, '?'));
        }

        return $requestUri;
    }
}