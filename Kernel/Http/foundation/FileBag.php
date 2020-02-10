<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/3/25
 * Time: 13:23
 */
namespace Kernel\Http\foundation;

class FileBag
{
    public $parameters;
    public $files;

    public function __construct(array $files = array())
    {
        $this->files = $files;
    }
}