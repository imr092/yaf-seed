<?php
/**
 * custom function helpers
 *
 * @param null $obj
 */

function pr($obj = null)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

function vd()
{
    echo '<pre>';
    foreach (func_get_args() as $a)
    {
        var_dump($a);
    }
}

function get_client_ip()
{
    if (isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
    }
    if (isset($_SERVER['HTTP_PROXY_USER']) && ! empty($_SERVER['HTTP_PROXY_USER'])) {
        return $_SERVER['HTTP_PROXY_USER'];
    }
    if (isset($_SERVER['REMOTE_ADDR']) && ! empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        return "0.0.0.0";
    }
}

function generateVCode($iLength = 4)
{
    return rand(pow(10, ($iLength - 1)), pow(10, $iLength) - 1);
}

function num10to62($num)
{
    if (! is_int($num) ? (ctype_digit($num)) : true) {
        $to   = 62;
        $dict = 'qpwoeirutyalskdjfhgzmxncbv1236547890QWERTYUIOPLKJHGFDSABVNCMXZ';
        $ret  = '';
        do {
            $ret = $dict[bcmod($num, $to)] . $ret;
            $num = bcdiv($num, $to);
        } while ($num > 0);

        return $ret;
    }

    return "";
}

function num62to10($num)
{
    $from = 62;
    $num  = strval($num);
    $dict = 'qpwoeirutyalskdjfhgzmxncbv1236547890QWERTYUIOPLKJHGFDSABVNCMXZ';
    $len  = strlen($num);
    $dec  = 0;
    for ($i = 0; $i < $len; $i++) {
        $pos = strpos($dict, $num[$i]);
        $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
    }

    return $dec;
}

function milliseconds()
{
    return (int)(microtime(true) * 1000);
}

function getAllParams()
{
    $params = Request::getParams();
    foreach ($_GET as $key => $value) {
        $params[$key] = Request::get($key);
    }
    foreach ($_POST as $key => $value) {
        $params[$key] = Request::getPost($key);
    }
    return $params;
}

function get($url)
{
    $curl = new Curl\Curl();
    $curl->get($url);
    if ($curl->error) {
        return '';
    }
    $response = $curl->response;
    $curl->close();
    $curl = null;
    unset($curl);

    return $response;
}

function post($url, $data)
{
    $curl = new Curl\Curl();
    $curl->post($url, $data);
    if ($curl->error) {
        return '';
    }
    $response = $curl->response;
    $curl->close();
    $curl = null;
    unset($curl);

    return $response;
}
