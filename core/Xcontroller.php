<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 7/4/15
 * Time: 21:47
 */

namespace Core;


class Xcontroller extends \Yaf_Controller_Abstract
{
    public $actions = [];

    protected function initModule($dir,$class)
    {
        $class = str_replace('Controller','',$class);
        $readPath = $dir.DIRECTORY_SEPARATOR.$class;
        $list = scandir($readPath);

        $path   = str_replace(APPLICATION_PATH,'',$readPath).DIRECTORY_SEPARATOR;

        foreach($list as $v){
            if(strpos($v,'.php') > 0){
                $action = str_replace('.php','',$v);
                $this->actions[strtolower($action)] = $path.$v;
            }
        }
    }
}