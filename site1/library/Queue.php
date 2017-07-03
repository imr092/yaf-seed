<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/17
 * Time: 16:44
 */

namespace Lib;

class Queue
{
    private static $url = 'http://127.0.0.1:9501/';
    public static function add($path, $params)
    {
        $params = http_build_query($params);
        $url = self::$url . "$path?$params";
        get($url);
    }
}