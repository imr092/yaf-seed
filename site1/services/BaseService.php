<?php

require_once dirname(dirname(__FILE__)) . '/library/Error.php';
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/18
 * Time: 21:27
 */

use Lib\Error;

abstract class BaseService
{

    abstract public function onRequests($request, $response);

    abstract public function onTask($serv, $task_id, $from_id, Array $data);

    protected function loadYaf()
    {
        if ( ! defined('YAF_APPLICATION_START')) {
            define('YAF_APPLICATION_START', 1);

            defined('APPLICATION_PATH') or define('APPLICATION_PATH', dirname(dirname(__FILE__)));
            defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', dirname(APPLICATION_PATH) . '/system');
            defined('ENDL') or define('ENDL', "\n");

            require_once APPLICATION_PATH . '/conf/conf.php';
            require_once FRAMEWORK_PATH . '/library/Functions.php';

            if (file_exists(APPLICATION_PATH . '/vendor/autoload.php')) {
                Yaf_Loader::import(APPLICATION_PATH . '/vendor/autoload.php');
            }
            if (file_exists(FRAMEWORK_PATH . '/vendor/autoload.php')) {
                Yaf_Loader::import(FRAMEWORK_PATH . '/vendor/autoload.php');
            }
            new Yaf_Application(APPLICATION_MAIN_CONFIG);
        }
    }

    protected function runYaf($data)
    {
        $uri        = explode('/', $data['request_uri']);
        $module     = isset($uri[0]) ? ucfirst(strtolower(array_shift($uri))) : 'Index';
        $controller = isset($uri[0]) ? ucfirst(strtolower(array_shift($uri))) : 'Index';
        $action     = isset($uri[0]) ? strtolower(array_shift($uri)) : 'index';
        $request    = new Yaf_Request_Simple("CLI", $module, $controller, $action, $data['params']);

        try {
            Application::app()->bootstrap()->getDispatcher()->dispatch($request);
            $result['content'] = ob_get_contents();
            @ob_end_clean();
        } catch (Exception $exception) {
            $result['error'] = Error::cliError($exception);
        }

        return json_encode($result);
    }

    private function loadSwoole($server_host, $server_port)
    {
        $this->_http = new swoole_http_server($server_host, $server_port);
        $this->_http->set([
            'ssl_cert_file'       => SSL_CERT_DIR . '/ssl.crt',
            'ssl_key_file'        => SSL_CERT_DIR . '/ssl.key',
            'open_http2_protocol' => true,
            'worker_num'          => 1,   //一般设置为服务器CPU数的1-4倍
            'daemonize'           => true,  //以守护进程执行
            'max_request'         => 10000, //
            'dispatch_mode'       => 2, // 数据包分发策略:固定模式
            'task_worker_num'     => 1,  //task进程的数量
            "task_ipc_mode "      => 3,  //使用消息队列通信，并设置为争抢模式
            'log_file'            => LOG_DIR . '/queue.log',
        ]);

        $this->_http->on('Request', array($this, 'onRequests'));
        $this->_http->on('Task', array($this, 'onTask'));
        $this->_http->on('Finish', function ($serv, $task_id, $data) {
            echo "Task {$task_id} finish | ";
            echo "Result: \n{$data}\n\n";
            $serv->stop();
        });
    }

    public $_http;
    public $application;

    public function __construct()
    {
        ob_start();
        $this->loadYaf();

        $ip   = isset($argv[1]) ? $argv[1] : HOST;
        $port = isset($argv[2]) ? $argv[2] : PORT;
        $this->loadSwoole($ip, $port);
    }

    public function run()
    {
        $this->_http->start();
    }
}

trait Singleton
{
    /**
     * private construct, generally defined by using class
     */
    //private function __construct() {}

    /**
     * @return static
     */
    private static $_instance;

    public static function getInstance()
    {
        if ( ! self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __clone()
    {
        trigger_error('Cloning ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
    }
}