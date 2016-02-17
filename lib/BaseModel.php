<?php
namespace Lib;

class BaseModel
{
    protected $mongo;
    protected $collection;
    protected $uid = 0;
    protected $dbName = '';
    protected $tableName = '';

    public function __construct($db, $table)
    {
        $this->dbName = $db;
        $this->tableName = $table;
        $this->mongo = MongoDatabase::instance($db);
        $this->collection = $this->mongo->db()->selectCollection($table);
    }

    public function insert($data, $options)
    {
        //$this->collection-
    }
}