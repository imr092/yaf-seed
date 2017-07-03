<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/17
 * Time: 03:38
 */
require_once 'BaseService.php';

date_default_timezone_set("Asia/Shanghai");
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

define('HOST', '127.0.0.1');
define('PORT', 9501);

define('SSL_CERT_DIR', __DIR__ . '/cert');
define('LOG_DIR', __DIR__ . '/logs');

class Queue extends BaseService
{
    use Singleton;

    public function onRequests($request, $response)
    {
        $response->status('200');
        $server = $request->server;

        // 检查请求分发任务
        $request_uri = 'index/index/index';
        if (isset($server['request_uri'])) {
            $request_uri = trim($server['request_uri'], '/');
        }

        $params = [];
        if (isset($server['query_string'])) {
            $query_string = $server['query_string'];
            parse_str($query_string, $params);
        }

        $data['request_uri'] = $request_uri;
        $data['params']      = $params;

        $this->_http->task($data);
        $result = ob_get_contents();
        @ob_end_clean();
        if (empty($result)) {
            $result = json_encode([
                'ret'   => 0,
                'error' => '',
                'data'  => $data,
            ]);
        }
        $response->end($result);
    }

    public function onTask($serv, $task_id, $from_id, Array $data)
    {
        return $this->runYaf($data);
    }
}

Queue::getInstance()->run();