<?php

/**
 * Class TestController
 */
class TestController extends BaseController
{

    //如果此controller的action过多,可以使用以下方式进行分文件管理

    public function init()
    {
        $this->initModule(__DIR__,__CLASS__);
    }
}
