<?php
namespace Kernel\Http\foundation;

class HeaderBag
{
    public $headers = array();

    public function __construct(array $headers = array())
    {
        foreach ($headers as $key => $values) {
            $this->set($key, $values);
        }
    }

    public function set($key, $values, $replace = true)
    {
        $this->headers[$key] = $values;
    }

    public function get($key, $default = null)
    {
        return $this->headers[$key];
    }
}