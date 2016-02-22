<?php
namespace App\Controllers;

use Lib\BaseController;
use Lib\Util\Config;

class IndexController extends BaseController
{
    public function index($params)
    {
        $levels = Config::loadData('level');
        $this->render('index.php', ['name' => $params['name']]);
    }

    public function add($params)
    {
        $db = new \Lib\BaseModel('default', 'test');
        //$db->insertOne(['_id' => 2, 'name' => 'paolo2']);
        $data = $db->find();
        return $this->json($data);
    }
}