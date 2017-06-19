<?php
//注册核心类命名空间
spl_autoload_register('coreLoader');
//注册公共类库命名空间
spl_autoload_register('plibLoader');

function coreLoader($classname)
{
    if (strpos($classname, 'Core\\') === 0) {
        $classname = str_replace('Core\\','core\\',$classname);
        $filename = FRAMEWORK_PATH . '/' . $classname . ".php";
        $filename = str_replace('\\', '/', $filename);
        include_once($filename);
    }
}

function plibLoader($classname)
{
    if (strpos($classname, 'Publib\\') === 0) {
        $classname = str_replace('Publib\\','publib\\',$classname);
        $filename = FRAMEWORK_PATH . '/' . $classname . ".php";
        $filename = str_replace('\\', '/', $filename);
        include_once($filename);
    }
}

function pr($obj = null)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}