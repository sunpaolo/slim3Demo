<?php
namespace Lib;

use Lib\Util\Config;
use Lib\Util\DBUtil;

/*
 * 可参考：
 * http://mongodb.github.io/mongo-php-library/classes/collection/
 * http://php.net/manual/zh/mongodb-driver-query.construct.php
 */
class BaseModel
{
    protected $db;
    protected $collection;
    protected $uid = 0;
    protected $dbName = '';
    protected $tableName = '';

    protected static $instances = [];

    public function __construct($db, $table)
    {
        if (is_numeric($db)) {
            $uid = intval($db);
            if (empty($uid)) {
                throw new \Exception('Error User');
            }
            $this->uid = $uid;
            $db = DBUtil::getDbName($uid);
        }
        $this->dbName = $db;
        $this->tableName = $table;
        $this->db = self::getConnection($db);
        $this->collection = $this->db->selectCollection($this->tableName);
    }

    public static function getConnection($db)
    {
        if (!isset(self::$instances[$db])) {
            $config = Config::loadConfig('database')[$db];
            $uri = $config['server'] ? 'mongodb://' . $config['server'] : '';
            $options = $config['options'] ?: [];
            $client = new \MongoDB\Client($uri, $options);
            self::$instances[$db] = $client->selectDatabase($config['database']);
        }
        return self::$instances[$db];
    }

    public function insertOne($document, array $options = [])
    {
        return $this->collection->insertOne($document, $options);
    }

    public function insertMany(array $documents, array $options = [])
    {
        return $this->collection->insertMany($documents, $options);
    }

    public function deleteOne($filter, array $options = [])
    {
        return $this->collection->deleteOne($filter, $options);
    }

    public function deleteMany($filter, array $options = [])
    {
        return $this->collection->deleteMany($filter, $options);
    }

    public function count($filter = [], array $options = [])
    {
        return $this->collection->count($filter, $options);
    }

    public function findOne($filter = [], array $options = [])
    {
        return $this->collection->findOne($filter, $options);
    }

    public function find($filter = [], array $options = [])
    {
        $cursor = $this->collection->find($filter, $options);
        return $cursor ? iterator_to_array($cursor) : [];
    }

    public function updateOne($filter, $update, array $options = [])
    {
        return $this->collection->updateOne($filter, $update, $options);
    }

    public function updateMany($filter, $update, array $options = [])
    {
        return $this->collection->updateMany($filter, $update, $options);
    }

    public function findOneAndUpdate($filter, $update, array $options = [])
    {
        return $this->collection->findOneAndUpdate($filter, $update, $options);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->collection, $method], $parameters);
    }
}