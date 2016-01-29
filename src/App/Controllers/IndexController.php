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
        return $this->json(['msms','emem']);
    }
}