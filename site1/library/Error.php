<?php

/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/6
 * Time: 11:35
 */

namespace Lib;

use LaravelArdent\Ardent\InvalidModelException;
use Lib\Pn\Exception as PnException;
use Request;
use Session;

class Error
{

    protected $disableActions = true;
    protected $disableView = true;

    public static function error($exception)
    {
        if (Request::isXmlHttpRequest()) {
            exit(self::ajaxError($exception));
        }

        if (Request::isCli()) {
            exit(self::cliError($exception));
        }

        if (APP_ENVIRON == 'development' || ! is_null(Request::get('debug'))) {
            pr($exception);
            exit;
        }

        $session = Session::getInstance();
        if (!empty($session->debug))
        {
            pr($exception);
            exit;
        }

        if ($exception instanceof InvalidModelException) {
            pr($exception->getErrors()->toArray());
            exit;
        }

        if ($exception instanceof PnException) {
            exit(json_encode([
                'ret'   => 1,
                'error' => $exception->getMessage(),
            ]));
        }

        exit($exception->getMessage());
    }

    public static function ajaxError($exception)
    {
        if ($exception instanceof InvalidModelException) {
            $message = $exception->getErrors()->toArray();
        } else {
            $message = $exception->getMessage();
        }

        return json_encode([
            'success' => 0,
            'message' => $message,
        ]);
    }

    public static function cliError($exception)
    {
        if ($exception instanceof InvalidModelException) {
            $message = print_r($exception->getErrors()->toArray());
        } else {
            $message = $exception->getMessage();
        }

        $data = date('Y-m-d H:i:s');
        return "[$data] $message \n";
    }
}