<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/2/28
 * Time: 17:25
 */
namespace Http\Common;

use Kernel\Http\foundation\Response;

final class BridgeResponse extends Response
{
    const SUCCESS = 200;
    const UNKNOWN = 999;

    public function __construct($statusCode = 200, $responseBody = '', array $extra = array())
    {
        $content = [
            'statusCode'      =>  $statusCode,
            'responseBody'    =>  $responseBody,
        ];

        if (!empty($extra)) {
            array_merge($content, $extra);
        }

        parent::__construct(json_encode($content), 200, []);
    }
}