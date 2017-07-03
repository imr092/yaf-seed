<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 7/4/15
 * Time: 21:47
 */

namespace Core;

use ReflectionClass;
use Request;
use Dispatcher;
use Yaf_Session;
use Application;

abstract class Controller extends \Yaf_Controller_Abstract
{

    final protected function init()
    {
        foreach (get_class_methods(get_called_class()) as $methodName) {
            if (strpos($methodName, '_init') !== false) {
                $this->$methodName();
            }
        }
    }

    final protected function _initFetchParamsForCli()
    {
        if (Request::isCli()) {
            global $argv;
            if (isset($argv[2])) {
                parse_str($argv[2], $params);
                foreach ($params as $key => $value) {
                    Request::setParam($key, $value);
                }
            }
        }
    }

    protected $action_names;
    public $actions = [];
    protected $disableActions = false;
    final protected function _initModule()
    {
        if (! $this->disableActions) {
            // fetch called class informations
            $class = get_called_class();
            $r = new ReflectionClass($class);
            $dir = dirname($r->getFileName());

            // parse dirname and action files
            $className = str_replace('Controller','',$class);
            $readPath = $dir.DIRECTORY_SEPARATOR.$className;
            $path   = str_replace(APPLICATION_PATH,'',$readPath).DIRECTORY_SEPARATOR;

            // load actions
            foreach($this->action_names as $v){
                $actionFile = ucfirst($v) . 'Action.' . Application::getConfig()->application->ext;
                $this->actions[$v] = $path.$actionFile;
            }
        }
    }

    protected $disableView = false;
    public function _initDisableView()
    {
        if ($this->disableView || Request::isCli()) {
            Dispatcher::disableView();
        }
    }

    public $session;
    protected function _initSession()
    {
        $this->session = Yaf_Session::getInstance();
    }

    protected $view;
    final protected function assign($name, $value = null) {
        $this->view = $this->getView();
        return $this->view->assign($name, $value);
    }

}
