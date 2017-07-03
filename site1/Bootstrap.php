<?php

/**
 * @name Bootstrap
 * @author  roger.s
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 */
class Bootstrap extends BootstrapAbstract
{

    public function _initSession()
    {
        Session::start();
    }

    private $public_config;

    public function _initConfig()
    {
        // save configures
        Registry::set('default_config', Application::getConfig());

        if (file_exists(FRAMEWORK_PATH . '/conf/consts.php')) {
            require_once(FRAMEWORK_PATH . '/conf/consts.php');
        }

        if (file_exists(FRAMEWORK_PATH . '/conf/public.php')) {
            $this->public_config = require_once(FRAMEWORK_PATH . '/conf/public.php');
            Registry::set('public_config', $this->public_config);
        }
    }

    public function _initDefaultDbAdapter($dispatcher)
    {
        if ( ! empty(Application::getConfig()->database)) {
            BaseModel::configureAsExternal(Application::getConfig()->database->toArray());
        }
    }

    public function _initPlugin($dispatcher)
    {
        // reg plugin
    }

    public function _initRoute($dispatcher)
    {
        // router register
        if ( ! Request::isCli()) {
            $uri        = array_merge(array_filter(explode('/', Request::getRequestUri())));
            $module     = isset($uri[0]) ? ucfirst(strtolower(array_shift($uri))) : DEFAULT_MODULE;
            $controller = isset($uri[0]) ? ucfirst(strtolower(array_shift($uri))) : DEFAULT_CONTROLLER;
            $action     = isset($uri[0]) ? strtolower(array_shift($uri)) : DEFAULT_ACTION;
            Request::setModuleName($module);
            Request::setControllerName($controller);
            Request::setActionName($action);
            Request::setRouted();
            for($i=0; $i<count($uri); $i+=2) {
                Request::setParam($uri[$i], isset($uri[$i+1])?$uri[$i+1]:null);
            }
        }
    }

    public function _initDisableViewForXmlHttpRequest($dispatcher)
    {
        if (Request::isXmlHttpRequest()) {
            Dispatcher::disableView();
        }
    }
}
