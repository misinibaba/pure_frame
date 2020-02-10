<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/3/25
 * Time: 13:23
 */
namespace Kernel\Http\foundation;

class ServerBag extends ParameterBag
{
    public function getHeaders()
    {
        $headers = array();
        $contentHeaders = array('CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true);
        foreach ($this->parameters as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            }
            // CONTENT_* are not prefixed with HTTP_
            elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}