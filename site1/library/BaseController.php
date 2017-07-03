<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 7/4/15
 * Time: 21:50
 */

use Lib\Pn\Sdk as PnSdk;
use User\UserModel;

abstract class BaseController extends \Core\Controller
{

    public $session;

    protected function _initSession()
    {
        $this->session = Session::getInstance();
    }

    public function _initDebug()
    {
        $debug = Request::get('debug');
        if (!empty($debug))
        {
            $session = $this->session;
            $session->debug = true;
        }
    }
}