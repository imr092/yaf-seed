<?php

error_reporting(E_ALL);ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);

define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('FRAMEWORK_PATH', dirname(APPLICATION_PATH));
define("CORE_PATH",  FRAMEWORK_PATH . '/core');

require APPLICATION_PATH.'/conf/conf.php';
require CORE_PATH.'/Init.php';

if (PHP_SAPI == 'cli')
{
    define('RUNTIME_DIR', FRAMEWORK_PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR);
    define('ENDL', "\n");
    $application = new Yaf_Application(APPLICATION_MAIN_CONFIG);
    $request     = new Yaf_Request_Simple();
    $application->bootstrap()->getDispatcher()->dispatch($request);
    echo ENDL . ENDL;
}
else
{
    header("Content-Type:text/html;charset=utf-8");
    define('ENDL', '<br />');
    $application = new Yaf_Application(APPLICATION_MAIN_CONFIG);
    $application->bootstrap()->run();
}
