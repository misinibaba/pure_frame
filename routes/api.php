<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/1
 * Time: 16:35
 */
namespace bootstrap\facades;

Route::get('/api/test/{id}','TestController@testList');