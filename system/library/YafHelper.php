<?php

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/7
 * Time: 21:37
 */

class BootstrapAbstract extends Yaf_Bootstrap_Abstract {}

class Registry extends YafStaticHelper {}
class Dispatcher extends YafInstanceHelper {}
class Loader extends YafInstanceHelper {}
class Router extends Yaf_DispatcherHelper {}
class Request extends Yaf_DispatcherHelper {}
class Application extends Yaf_DispatcherHelper {
    public static function getInstance($config) {
        return new Yaf_Application($config);
    }
}

abstract class YafStaticHelper
{
    public static function __callStatic($name, $arguments)
    {
        $class = 'Yaf_' . get_called_class();
        return call_user_func_array("$class::$name", $arguments);
    }
}

abstract class YafInstanceHelper
{
    public static function __callStatic($name, $arguments)
    {
        $class = 'Yaf_' . get_called_class();
        return call_user_func_array([$class::getInstance(), $name], $arguments);
    }
}

abstract class Yaf_DispatcherHelper
{
    public static function __callStatic($name, $arguments)
    {
        $yafGetFunction = 'get' . get_called_class();
        return call_user_func_array([Dispatcher::$yafGetFunction(), $name], $arguments);
    }
}

class View
{
    private static $_instance;
    public static function getInstance() {
        if (!self::$_instance instanceof Yaf_View_Simple) {
            self::$_instance = new Yaf_View_Simple(Application::getAppDirectory() . '/modules/' . Request::getModuleName() . '/views');
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error('Cloning '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::getInstance(), $name], $arguments);
    }
}

class Session extends YafInstanceHelper
{
    public static function getInstance()
    {
        return Yaf_Session::getInstance();
    }
}
