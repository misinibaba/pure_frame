<?php
//if (! function_exists('view')) {
//    function view($view = null, $data = [])
//    {
//        foreach ($data as $k => $v) {
//            $$k = $v;
//        }
//
//        $viewPath = ROOT_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
//        foreach (explode('.', $view) as $segment) {
//            $viewPath .= DIRECTORY_SEPARATOR . $segment;
//        }
//        $viewPath .= '.php';
//        if (file_exists($viewPath)) {
//            require ($viewPath);
//        }
//    }
//}

if (! function_exists('app')) {
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return \bootstrap\facades\App::get('app');
        }

        return \bootstrap\facades\App::get($make, $parameters);
    }
}

if (! function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            if (!file_exists(ROOT_PATH . '/.env')) {
                throw new Exception('.env文件不存在');
            }

            $env = file_get_contents(ROOT_PATH . '/.env');
            $env = explode(PHP_EOL, $env);
            $envArr = [];
            foreach ($env as $str) {
                $str = trim($str, "\r");
                $str = trim($str, "\r\n");
                $str = trim($str, "\n");
                if (empty($str)) {
                    continue;
                }

                list($envKey, $envValue) = explode('=', $str);
                $envArr[$envKey] = $envValue;
            }

            return isset($envArr[$key]) ? $envArr[$key] : $default;
        }

        return $value;
    }
}

if (! function_exists('current_url')) {
    function current_url()
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $current_url = $http_type . $_SERVER['HTTP_HOST'];
        if (env('APP_ENV', '') == 'prd_sc' ) {
            $port = ($http_type == 'http://') ? '10080' : '10433';
            $current_url .= ':' . $port;
        }

        return $current_url;
    }
}

if (! function_exists('view')) {
    function view($name, $data = [], $mergeData = [])
    {
        $blade = app('blade');

        if (func_num_args() === 0) {
            return $blade;
        }

        return $blade->view()->make($name, $data, $mergeData);
    }
}

if (! function_exists('asset')) {
    function asset($path, $secure = null)
    {
        return current_url() . DIRECTORY_SEPARATOR . $path;
    }
}