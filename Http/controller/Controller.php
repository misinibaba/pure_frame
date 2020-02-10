<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 15:50
 */
namespace Http\controller;
use bootstrap\facades\Config;
use Kernel\Http\foundation\Response;

class Controller
{
    protected $request;

    public function callAction($method, $parameters)
    {
        $this->request = $parameters['request'];
        unset($parameters['request']);

        $this->openXhprof();
        $response =  call_user_func_array([$this, $method], $parameters);
        $response = $this->closeXhprof($response);
        return $response;
    }

    public function openXhprof()
    {
        if (!Config::get('app.xhprof')) {
            return ;
        }
        \xhprof_enable();
    }

    public function closeXhprof($response)
    {
        if (!Config::get('app.xhprof')) {
            return $response;
        }

        $xhprof_data = xhprof_disable();
        $XHPROF_ROOT = Config::get('app.xhprof_path');
        include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_lib.php';
        include_once $XHPROF_ROOT . '/xhprof_lib/utils/xhprof_runs.php';
        $xhprof_runs = new \XHProfRuns_Default();
        $XHPROF_SOURCE_NAME = $this->request->get('xhprof_name', 'CodeIgniter');
        $run_id = $xhprof_runs->save_run( $xhprof_data, $XHPROF_SOURCE_NAME );

        if (!$response instanceof Response) {
            $response .= Config::get('app.xhprof_url') . '/xhprof_html/index.php?run=' . $run_id . '&source=' . $XHPROF_SOURCE_NAME ;
            return $response;
        }

        $content = $response->getContent();
        $content = substr( $content, 0, -1 );
        $content .= ',"xprof":"' . Config::get('app.xhprof_url') . '/xhprof_html/index.php?run=' . $run_id . '&source=' . $XHPROF_SOURCE_NAME . '"}';
        $response->setContent($content);
        return $response;
    }
}