<?php

/**
 * Created by PhpStorm.
 * User: garming
 * Date: 12/29/15
 * Time: 22:58
 */
class AnotherController extends BaseController
{
    //如果此controller的action不多,可以直接在这里写action
    protected function _init(){
        //yaf的init方法,执行所有action前,它会自动运行
    }

    public static function indexAction()
    {
        //action
        echo "Another::indexAction";
    }
}