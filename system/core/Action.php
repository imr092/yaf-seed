<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 7/4/15
 * Time: 21:47
 */

namespace Core;

use Request;

abstract class Action extends \Yaf_Action_Abstract
{
    protected $view;

    final protected function assign($name, $value = null)
    {
        $this->view = $this->getView();

        return $this->view->assign($name, $value);
    }

    public function session()
    {
        return $this->getController()->session;
    }
}