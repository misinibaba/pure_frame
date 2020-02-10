<?php
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require ROOT_PATH . '/vendor/autoload.php';
    return 1;
} else {
    require_once __DIR__ . '/loader.php';
    return Loader::bindLoad();
}

