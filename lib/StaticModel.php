<?php
namespace Lib;

/*
 * Unit of work 模式，减少数据库操作次数
 */
class StaticModel
{
    private $originalData = null; //原始数据
    private $newData = null; //修改后的数据
    private $uid = 0;
    private $mongo;
    private static $classMaps = [];

    protected $defaultUpdateOptions = ['upsert' => true];

    public function __construct($uid, $table)
    {
        $this->uid = $uid;
        $mc = new \MongoClient('mongodb://192.168.1.217:27017');
        $this->mongo = $mc->selectDB('test')->selectCollection($table);
    }

    protected function getPrimaryKey()
    {
        return $this->uid;
    }

    /*
     * 获取一条记录
     */
    public function findOne()
    {
        if ($this->newData !== null) {
            return $this->newData;
        }
        $where = ['_id' => $this->getPrimaryKey()];
        $this->newData = $this->originalData = $this->mongo->findOne($where);
        return $this->newData;
    }

    /*
     * 更新数据
     */
    public function update($updates)
    {
        if (!is_array($updates)) {
            return false;
        }
        //更新前获取下新数据
        $this->findOne();

        $updates = $this->checkUpdates($updates);
        //更新数据
        foreach ($updates as $operator => $update) {
            foreach ($update as $field => $value) {
                switch ($operator) {
                    case '$set':
                        $newValue = $value;
                        break;
                    case '$inc':
                        $tmp = $this->get($field, 0);
                        $newValue = $tmp + $value;
                        break;
                    case '$unset':
                        $newValue = null;
                        break;
                    case '$push':
                        $newValue = $this->get($field, []);
                        if (!$this->isMongoArray($newValue)) {
                            throw new \Exception('$push non-array');
                        }
                        $newValue[] = $value;
                        break;
                    case '$pop':
                        $newValue = $this->get($field, []);
                        if (!$this->isMongoArray($newValue)) {
                            throw new \Exception('$pop non-array');
                        }
                        if ($value < 0) {
                            array_pop($newValue);
                        } else {
                            array_shift($newValue);
                        }
                        break;
                    case '$pull':
                        $tmp = $this->get($field, []);
                        if (!$this->isMongoArray($tmp)) {
                            throw new \Exception('$pull non-array');
                        }
                        $newValue = [];
                        foreach ($tmp as $v) {
                            if ($v != $value) {
                                $newValue[] = $v;
                            }
                        }
                        break;
                    case '$addToSet':
                        $newValue = $this->get($field, []);
                        if (!$this->isMongoArray($newValue)) {
                            throw new \Exception('$addToSet non-array');
                        }
                        if (isset($value['$each'])) {
                            foreach ($value['$each'] as $val) {
                                if (!in_array($val, $newValue)) {
                                    $newValue[] = $val;
                                }
                            }
                        } else {
                            if (!in_array($value, $newValue)) {
                                $newValue[] = $value;
                            }
                        }
                        break;
                    default:
                        throw new \Exception('Unsupport Operator :' . $operator);
                }
                $this->set($field, $newValue);
            }
        }

        $this->changed();

        return $this->newData;
    }

    public function insert($data)
    {
        if ($this->newData) {
            return $this->newData;
        }

        $where = ['_id' => $this->getPrimaryKey()];
        if ($this->defaultUpdateOptions['upsert']) {
            $this->newData = $where + $this->newData;
        }

        $this->mongo->insert($data);
        $this->newData = $this->originalData = $data;
        return $this->newData;
    }

    public function remove()
    {
        $where = ['_id' => $this->getPrimaryKey()];
        $this->mongo->remove($where);
        $this->newData = $this->originalData = null;
    }

    /*
     * 是否有更新
     * 维护$classMaps列表，以便统一更新
     */
    private function changed()
    {
        $oid = spl_object_hash($this);
        self::$classMaps[$oid] = $this;
    }

    /*
     * 只更新修改的字段
     */
    private function checkDiff($originalData, $newData, $preKey = '')
    {
        $diffs = [];
        foreach ($newData as $field => $value) {
            $currentKey = $preKey ? $preKey . '.' . $field : $field;
            //新增的数据
            if (!isset($originalData[$field])) {
                if (is_int($value)) {
                    $diffs[$currentKey] = array('type' => '$inc', 'data' => $value);
                } else {
                    $diffs[$currentKey] = array('type' => '$set', 'data' => $value);
                }
                continue;
            }
            //数组递归对比
            if (is_array($value)
                && is_array($originalData[$field])
                && !$this->isMongoArray($value)
                && !$this->isMongoArray($originalData[$field])) {
                $diffs = array_merge($diffs, $this->checkDiff($originalData[$field], $value, $currentKey));
                continue;
            }
            //更新数据
            if ($originalData[$field] != $value) {
                if (is_int($value) && is_int($originalData[$field])) {
                    $diffs[$currentKey] = array('type' => '$inc', 'data' => $value - $originalData[$field]);
                } else {
                    $diffs[$currentKey] = array('type' => '$set', 'data' => $value);
                }
                continue;
            }
        }
        //删除的数据
        if (!empty($originalData)) {
            foreach ($originalData as $field => $value) {
                $currentKey = $preKey ? $preKey . '.' . $field : $field;
                if (!isset($newData[$field])) {
                    $diffs[$currentKey] = ['type' => '$unset', 'data' => 1];
                }
            }
        }
        return $diffs;
    }

    /*
     * 更新当前最新数据到数据库
     */
    public function flush()
    {
        $where = ['_id' => $this->getPrimaryKey()];
        //只更新修改的字段
        $diffs = $this->checkDiff($this->originalData, $this->newData, '');
        $updates = [];//最终修改的字段
        foreach ($diffs as $key => $value) {
            $type = $value['type'];
            $updates[$type][$key] = $value['data'];
        }
        if ($updates) {
            $this->mongo->update($where, $updates, $this->defaultUpdateOptions);
        }
    }

    /*
     * 更新到数据库
     */
    public static function flushAll()
    {
        foreach (self::$classMaps as $oid => $class) {
            $class->flush();
        }
    }

    /*
     * 没有使用操作符时默认设置为$set操作
     * 防止操作顺序发生变化，不使用unset
     */
    private function checkUpdates($updates)
    {
        $newUpdates = [];
        foreach ($updates as $key => $value) {
            if ($key[0] !== '$') {
                $newUpdates['$set'][$key] = $value;
            } else {
                $newUpdates[$key] = $value;
            }
        }
        return $newUpdates;
    }

    /*
     * PHP语言的特殊，验证array是否为Mongo里的array
     */
    private function isMongoArray($document)
    {
        return $document === '' || $document === NULL || (is_array($document) && $document === array_values($document));
    }

    /*
     * 获取某个key的值
     */
    private function get($key, $default = null)
    {
        $segs = explode('.', $key);
        $root = $this->newData;
        // nested case
        foreach ($segs as $part) {
            if (isset($root[$part])) {
                $root = $root[$part];
            } else {
                $root = $default;
                break;
            }
        }
        return $root;
    }

    /*
     * 设置某个key的值
     */
    private function set($key, $value)
    {
        //删除null字段
        if ($value === null) {
            $this->unsetField($key);
            return;
        }
        $segs = explode('.', $key);
        $root = &$this->newData;
        foreach ($segs as $part) {
            $root = &$root[$part];
        }
        $root = $value;
    }

    /*
     * 删除字段
     */
    private function unsetField($key)
    {
        $segs = explode('.', $key);
        $root = &$this->newData;

        $last = array_pop($segs);
        foreach ($segs as $part) {
            $root = &$root[$part];
        }

        if ($this->isMongoArray($root)) {
            array_splice($root, $last, 1);
        } else {
            unset($root[$last]);
        }
    }
}
