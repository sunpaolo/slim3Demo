<?php
namespace Lib\Session;

use Lib\MC;

class MemcachedSession
{
    public function start()
    {
        ini_set('session.gc_probability', 50);
        ini_set('session.save_handler', 'user');
        ini_set('session.cookie_domain', null);
        session_set_save_handler(
            array($this,'open'),
            array($this,'close'),
            array($this,'read'),
            array($this,'write'),
            array($this,'destroy'),
            array($this,'gc')
        );
        session_start();
    }

    public function open($path, $name)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($sid)
    {
        return MC::get($sid);
    }

    public function write($sid, $data)
    {
        MC::set($sid, $data);
        return true;
    }

    public function destroy($sid)
    {
        MC::delete($sid);
        return true;
    }

    public function gc($maxlifetime)
    {
        return true;
    }
}