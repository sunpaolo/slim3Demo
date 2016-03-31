<?php
namespace Lib\Session;

use Lib\BaseModel;

/*
 * 表结构如下
 * {
 *      "session_id":"",
 *      "session_value":"",
 *      "expire":3600
 * }
 */
class MongoSession
{
    public function start()
    {

    }

    public function open($path, $name)
    {
        $mongo = new BaseModel('common', 'session');
        return true;
    }
}