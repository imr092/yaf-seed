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

    public function _initToken()
    {
        // check token
        $session = $this->session;
        $session->app_id = 1;
        $token   = Request::get('token');
        if ( ! empty($token)) {
            $uid = PnSdk::getInstance()->getUidByToken($token);
            if (empty($uid)) {
                throw new Exception('invalid user');
            }
            /**
             * @var \User\UserModel $user
             */
            $user = UserModel::firstOrCreate([
                'app_id'      => $session->app_id,
                'app_user_id' => $uid,
            ]);

            // set session
            $session->user_id = $user->user_id;
        }
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