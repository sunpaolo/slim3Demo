<?php
namespace Lib\Util;

class CommonUtil
{
    public static function setToken($uid)
    {

    }

    public static function getToken($uid)
    {

    }

    public static function getShardUids($ids)
    {

    }

    public static function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }
}