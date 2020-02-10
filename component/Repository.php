<?php
/**
 * 支持$app->set($k ,$v)以及$app[$k] = $v格式赋值
 */
namespace component;

use ArrayAccess;


class Repository implements ArrayAccess
{
    public $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function has($key)
    {
        if (is_null($key)) {
            return false;
        }

        if (! $this->items) {
            return false;
        }

        if ($this->items instanceof ArrayAccess) {
            return $this->items->offsetExists($key);
        }

        return array_key_exists($key, $this->items);
    }

    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function get($key, $default = null)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        $array = $this->items;

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    public function all()
    {
        return $this->items;
    }


    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        return $this->get($offset);
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        return $this->has($offset);
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
        unset($this->items[$offset]);
    }
}