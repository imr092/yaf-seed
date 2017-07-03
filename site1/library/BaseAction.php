<?php

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/15
 * Time: 18:45
 */

use User\UserModel;

abstract class BaseAction extends \Core\Action
{
    /**
     * @return \User\UserModel
     * @throws Exception
     */
    public function checkLogin()
    {
        $session = $this->session();

        $user_id = $session->user_id;

        if (empty($user_id))
        {
            throw new Exception('not login');
        }

        $user = UserModel::find($user_id);
        if (empty($user))
        {
            throw new Exception('invalid user');
        }

        return $user;
    }
}
