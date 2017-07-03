<?php
/**
 * @var $uri
 */
$uri = 'daemon/index/index';

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/17
 * Time: 02:36
 */
date_default_timezone_set("Asia/Shanghai");
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('FRAMEWORK_PATH', dirname(APPLICATION_PATH) . '/system');

require APPLICATION_PATH . '/conf/conf.php';
require FRAMEWORK_PATH . '/library/Functions.php';
require FRAMEWORK_PATH . '/library/YafHelper.php';

if (file_exists(APPLICATION_PATH . '/vendor/autoload.php')) {
    Loader::import(APPLICATION_PATH . '/vendor/autoload.php');
}

if (file_exists(FRAMEWORK_PATH . '/vendor/autoload.php')) {
    Loader::import(FRAMEWORK_PATH . '/vendor/autoload.php');
}

define('RUNTIME_DIR', FRAMEWORK_PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR);
define('ENDL', "\n");
$application = Application::getInstance(APPLICATION_MAIN_CONFIG);
$uri = explode('/', $uri);
$request = new Yaf_Request_Simple("CLI", $uri[0], $uri[1], $uri[2], [
    'argc' => $argc,
    'argv' => $argv,
]);
$application->bootstrap()->getDispatcher()->dispatch($request);
echo ENDL . ENDL;
