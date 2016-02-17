<?php
namespace Lib;

use Lib\Util\Config;

class MongoDatabase
{
    private $name;
    private $connected = false;
    private $connection;
    private $db;

    protected function __construct($name, array $config)
    {
        $this->name = $name;
        $options = [
            'connect' => false //需要的时候才连接
        ];
        if ($config['options']) {
            $options = array_merge($options, $config['options']);
        }
        $server = $config['server'] ?: 'mongodb://localhost:27017';
        $this->connection = new \MongoClient($server, $options);
        $this->db = $config['database'];
    }

    /*
     * 单例模式
     */
    public static function instance($name = 'default', array $config = null, $override = false)
    {
        if ($override || !isset(self::$instances[$name])) {
            if (empty($config)) {
                $config = Config::loadConfig('database');
            }
            self::$instances[$name] = new static($name, $config[$name]);
        }
        return self::$instances[$name];
    }

    final public function __destruct()
    {
        try {
            $this->close();
            $this->connection = NULL;
            $this->connected = FALSE;
        } catch(\Exception $e) {
            //do nothing
        }
    }

    final public function __toString()
    {
        return $this->name;
    }

    public function connect()
    {
        if (!$this->connected) {
            $this->connected = $this->connection->connect();
            $this->db = $this->connection->selectDB("$this->db");
        }
        return $this->connected;
    }

    public function close()
    {
        if ($this->connected) {
            $this->connected = $this->connection->close(TRUE);
            $this->db = "$this->db";
        }
        return $this->connected;
    }

    public function db()
    {
        $this->connected OR $this->connect();
        return $this->db;
    }

    public function __get($name)
    {
        return $this->db()->selectCollection($name);
    }

    public function __call($method, $args)
    {
        $this->connected OR $this->connect();
        if (!method_exists($this->db, $method)) {
            throw new Exception("Method does not exist: MongoDb::$method");
        }
        return call_user_func_array([$this->db, $method], $args);
    }
}