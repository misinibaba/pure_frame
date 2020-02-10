<?php
namespace Kernel\Http;

use Kernel\Http\foundation\FileBag;
use Kernel\Http\foundation\ParameterBag;
use Kernel\Http\foundation\ServerBag;
use Kernel\Http\foundation\HeaderBag;

/**
 * 请求对象
 * Class Request
 * @package Kernel\Http
 */
class Request
{
    public $query;
    public $request;
    public $cookies;
    public $files;
    public $server;
    public $header;

    public $method;
    public $headers;

    public function __construct(array $query = array(), array $request = array(), array $cookies = array(), array $files = array(), array $server = array())
    {
        $this->query = new ParameterBag($query);
        $this->request = new ParameterBag($request);
        $this->cookies = new ParameterBag($cookies);
        $this->files = new FileBag($files);
        $this->server = new ServerBag($server);
        $this->header = new HeaderBag($this->server->getHeaders());
    }

    /**
     * 解析数据到对象
     * @return Request
     */
    public static function capture()
    {
        $request = new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
        return $request;
    }

    /**
     * 获取本次调用的方法
     * @return string
     */
    public function getMethod()
    {
        if (null === $this->method) {
            $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));

            if ('POST' === $this->method) {
                if ($method = $this->headers->get('X-HTTP-METHOD-OVERRIDE')) {
                    $this->method = strtoupper($method);
                }
            }
        }

        return $this->method;
    }

    public function get($key, $default = null)
    {
        if ($this !== $result = $this->query->get($key, $this)) {
            return $result;
        }

        return $default;
    }
}