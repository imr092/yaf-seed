<?php

namespace Core;
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/15
 * Time: 21:44
 */
trait Singleton {
    /**
     * private construct, generally defined by using class
     */
    //private function __construct() {}

    /**
     *
     * @return static
     */
    private static $_instance;
    public static function getInstance() {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error('Cloning '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }
}