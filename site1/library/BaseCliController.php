<?php

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/17
 * Time: 00:30
 */
class BaseCliController extends \Core\Controller
{
    public $disableView = true;

    public function _initCheckCli()
    {
        if (empty(Request::get('debug')) && ! Request::isCli()) {
            throw new Exception('only run under cli');
        }
    }
}