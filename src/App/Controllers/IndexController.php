<?php
namespace App\Controllers;

use Lib\BaseController;
use Lib\Util\Config;
use Respect\Validation\Validator;

class IndexController extends BaseController
{
    public function index($params)
    {
        Validator::notEmpty()->setName('name')->check($params['name']);
        Validator::notEmpty()->setName('password')->check($params['password']);

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