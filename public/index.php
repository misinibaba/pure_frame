<?php
/**
 * Created by PhpStorm.
 * User: S3916
 * Date: 2019/2/19
 * Time: 11:37
 */

define('ROOT_PATH',  __DIR__ . '/../');
require_once ROOT_PATH . '/Kernel/Http/foundation/helpers.php';
require_once ROOT_PATH . '/bootstrap/autoload.php';

$app = require_once ROOT_PATH . '/bootstrap/app.php';
$kernel = $app->get('kernel');

$response = $kernel->handle(
    $request = Kernel\Http\Request::capture()
);

$response->send();