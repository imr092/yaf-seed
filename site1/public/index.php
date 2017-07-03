<?php
date_default_timezone_set("Asia/Shanghai");

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('FRAMEWORK_PATH', dirname(APPLICATION_PATH) . '/system');

require APPLICATION_PATH . '/conf/conf.php';
require FRAMEWORK_PATH . '/library/Functions.php';

if (file_exists(APPLICATION_PATH . '/vendor/autoload.php')) {
    Yaf_Loader::import(APPLICATION_PATH . '/vendor/autoload.php');
}

if (file_exists(FRAMEWORK_PATH . '/vendor/autoload.php')) {
    Yaf_Loader::import(FRAMEWORK_PATH . '/vendor/autoload.php');
}

set_exception_handler(function ($e){\Lib\Error::error($e);});

if (PHP_SAPI == 'cli') {
    define('RUNTIME_DIR',
        FRAMEWORK_PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR);
    define('ENDL', "\n");
    $application = new Yaf_Application(APPLICATION_MAIN_CONFIG);
    $request     = new Yaf_Request_Simple("CLI", $uri[0], $uri[1], $uri[2], $data['params']);
    $application->bootstrap()->getDispatcher()->dispatch($request);
    echo ENDL . ENDL;
} else {
    header("Content-Type:text/html;charset=utf-8");
    define('ENDL', '<br />');
    $application = new Yaf_Application(APPLICATION_MAIN_CONFIG);
    $application->bootstrap()->run();
}