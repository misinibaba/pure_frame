<?php
/**
 * 加载配置文件
 */
namespace bootstrap\base;

use component\Repository;
use Kernel\Application;

class LoadConfiguration
{
    public function bootstrap(Application $app)
    {
        $app->instance('config', $config = new Repository());

        $configPath = $app->configPath();
        if (is_dir($configPath)) {
            $dp = dir($configPath);
            while (($file = $dp->read()) !== false) {
                if (substr($file, -4) == '.php') {
                    $basename = str_replace(strrchr($file, '.'), '', $file);
                    $path = $dp->path . DIRECTORY_SEPARATOR . $file;
                    $config->set($basename, require $path);
                }
            }
        }

        date_default_timezone_set($config['app.timezone']);

        mb_internal_encoding('UTF-8');

        if ($config['app.debug']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
    }
}