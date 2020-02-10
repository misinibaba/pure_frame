<?php
class Loader
{
    /**
     * 自动加载类
     * @param $className string 类名，需要new的时候遵循psr-4
     * @throws Exception
     */
    public static function loadClass($className)
    {
        $className = strtr($className, '\\', DIRECTORY_SEPARATOR);
        if (file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . $className . '.php')) {
            include_once ROOT_PATH . DIRECTORY_SEPARATOR . $className . '.php';
        } else {
            throw new Exception('未找到类：' . ROOT_PATH . DIRECTORY_SEPARATOR . $className . '.php');
        }
        return ;
    }

    public static function bindLoad()
    {
        spl_autoload_register(array('Loader', 'loadClass'), true, true);
        return 1;
    }
}