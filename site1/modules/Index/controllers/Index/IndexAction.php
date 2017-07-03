<?php

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/18
 * Time: 19:22
 */
class IndexAction extends BaseAction
{
    public function execute()
    {
        $session = $this->session();
        $this->assign('session', $session);
    }
}