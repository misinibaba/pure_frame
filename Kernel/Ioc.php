<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 11:43
 */
namespace Kernel;
use ReflectionClass;

class Ioc implements \ArrayAccess
{
    protected static $instance; // 自身

    public $ioc; // 名字以及实现方式
    public $instances; // 已经实现好的单例
    public $aliases; // 类的别名，用于get的时候找到对应的类缩写，例如 app => 'Kernel\Application'

    /**
     * 从类名中解析出实例
     * @param $className mixed 类名
     * @return mixed|object
     * @throws \Exception
     */
    public function get($className)
    {
        // 先获取别名
        $className = $this->getAlias($className);

        // share则返回单例
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }

        // 从类名中获取实例，构建处类
        $concrete = $this->getConcrete($className);
        $instances = $this->build($concrete);

        if ($this->isShared($className)) {
            $this->instances[$className] = $instances;
        }
        return $instances;
    }

    /**
     * 注入实例到类
     * @param $name
     * @param $class
     * @param bool $share
     */
    public function set($name, $class, $share = false)
    {
        $this->ioc[$name] = [
            'class' => $class,
            'share' => $share
        ];
    }

    /**
     * 注入单例
     * @param $name
     * @param $class
     */
    public function single($name, $class) {
        $this->set($name, $class, true);
    }

    /**
     * 是否是共享(单例)
     * @param $name
     * @return bool
     */
    public function isShared($name)
    {
        if (isset($this->ioc[$name]['share'])) {
            $shared = $this->ioc[$name]['share'];
        } else {
            $shared = false;
        }
        return isset($this->instances[$name]) || $shared === true;
    }

    /**
     * 获取实例
     * @param $name
     * @return mixed
     */
    public function getConcrete($name)
    {
        // 如果还没有注入，直接返回名字去build
        if (!isset($this->ioc[$name])) {
            return $name;
        }
        return $this->ioc[$name]['class'];
    }

    /**
     * 构建实例
     * @param $concrete
     * @param array $parameters
     * @return mixed|object
     * @throws \ReflectionException
     */
    public function build($concrete, $parameters = [])
    {
        // 已经注入为闭包就直接返回
        if ($concrete instanceof \Closure) {
            return $concrete($this);
        }

        // 如果是类似'\Kernel\Kernel::class'这种形式存储的，而不是闭包，则通过映射获取类
        // 因为需要映射类来获取依赖
        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new \Exception("[$concrete]无法被实例化");
        }

        // 如果没有构造函数则意味着没有依赖，直接new返回
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $concrete();
        }

        $dependencies = $constructor->getParameters();  // 获取依赖参数名
        $instances = $this->getDependencies($dependencies, $parameters); // 根据依赖参数名获取依赖的实例或参数

        return $reflector->newInstanceArgs($instances); // 如果是kernel则会
    }

    public function getDependencies(array $parameters, array $primitives = [])
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();// 根据参数名尝试获取类,如果获取不到则不是类
            if (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter); // 依赖的不是类
            } else {
                $dependencies[] = $this->resolveClass($parameter);    // 依赖的是类
            }

        }
        return (array) $dependencies;
    }

    protected function resolveNonClass(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        // 没有默认值则无法解析
        $message = "类： {$parameter->getDeclaringClass()->getName()} 无法解析其中的依赖项";
        throw new \Exception($message);
    }

    protected function resolveClass(\ReflectionParameter $parameter)
    {
        try {
            // 如果依赖的类是Application,则会重新去get一下,然而获取的是Kernel\Application或bootstrap\routing\Router这种全名，所以需要alise指定一下，只取对应的值就行啦
            return $this->get($parameter->getClass()->name);
        } catch (\Exception $e) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            }
            throw $e;
        }
    }

    /**
     * 绑定类实例到类名，单例情况下用
     * @param $name
     * @param $instances
     */
    public function instance($name, $instances)
    {
        $this->instances[$name] = $instances;
    }

    public function getAlias($className)
    {
        if (!isset($this->aliases[$className])) {
            return $className;
        }

        return $this->aliases[$className];
    }

    public function share(\Closure $closure)
    {
        return function ($ioc) use ($closure) {
            return $closure($ioc);
        };
    }

    public function offsetExists($key)
    {
        return isset($this->instance[$key]) || isset($this->ioc[$key]);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        if (! $value instanceof \Closure) {
            $value = function () use ($value) {
                return $value;
            };
        }

        $this->set($key, $value);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }


    public function offsetUnset($key)
    {
        unset($this->ioc[$key], $this->instances[$key]);
    }


    public function __get($key)
    {
        return $this[$key];
    }

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

}