<?php

/**
 * @name Bootstrap
 * @author  garming
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    private $public_config;
    public function _initConfig()
    {
        // 把配置保存起来
        $arrConfig = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('default_config', $arrConfig);
        $file_consts = Yaf_Application::app()->getConfig()->application->directory . '/../conf/consts.php';
        if(file_exists($file_consts)){
            require_once ($file_consts);
        }
        if(file_exists(FRAMEWORK_PATH . '/conf/public.php')){
            $this->public_config = require_once (FRAMEWORK_PATH . '/conf/public.php');
            Yaf_Registry::set('public_config', $this->public_config);
        }

    }

    public function _initLoader()
    {
        if(file_exists(FRAMEWORK_PATH . '/composer/vendor/autoload.php')){
            Yaf_Loader::import(FRAMEWORK_PATH . '/composer/vendor/autoload.php');
        }
    }


    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    {
        // 注册一个插件
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        // 在这里注册自己的路由协议,默认使用简单路由

        //如果下下面的注释打开,则所有路由都会走modules
        /*if ($_SERVER['REQUEST_URI'] != '/') {
            $uri = array_merge(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
            $request = $dispatcher::getInstance()->getRequest();
            switch (count($uri)) {
                case 1:
                    $request->setModuleName(ucfirst($uri[0]));
                    $request->setControllerName('Index');
                    $request->setActionName("index");
                    $request->setRouted();
                    break;
                case 2:
                    $request->setModuleName(ucfirst($uri[0]));
                    $request->setControllerName(ucfirst($uri[1]));
                    $request->setActionName("index");
                    $request->setRouted();
                    break;
                default:
            }
        }*/
    }
}
