<?php
namespace Lib;

use Lib\Util\Config;
/*
 * Memcached
 */
class MC
{
    protected static $instance;

    private static function getInstance()
    {
        if (!empty(self::$instance)) {
            return self::$instance;
        }

        $config = Config::loadConfig('cache');
        $driver = $config['driver'];
        if (!extension_loaded($driver)) {
            throw new Exception("error driver [$driver]");
        }
        $servers = $config['servers'] ?: [];
        $options = $config['options'] ?: [];
        $mc = new Memcached();
        $mc->setOptions($options);
        $mc->addServers($servers);
        return self::$instance = $mc;
    }

    public static function get($key, $default = NULL, $cas = NULL)
    {
        return self::getInstance()->get($key, $default, $cas);
    }

    public static function set($key, $value, $ttl = 86400)
    {
        return self::getInstance()->set($key, $value, $ttl);
    }

    public static function add($key, $value, $ttl = 86400)
    {
        return self::getInstance()->add($key, $value, $ttl);
    }

    public static function inc($key, $offset, $init = 0, $ttl = 86400)
    {
        return self::getInstance()->increment($key, $offset, $init, $ttl);
    }

    public static function cas($cas, $key, $value, $ttl = 86400)
    {
        return self::getInstance()->cas($cas, $key, $value, $ttl);
    }

    public static function delete($key)
    {
        return self::getInstance()->delete($key);
    }
}