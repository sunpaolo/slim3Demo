<?php
namespace App\Controllers;

use Lib\BaseController;

class IndexController extends BaseController
{
    public function index($params)
    {
        $this->render('index.php', ['name' => $params['name']]);
    }

    public function add($params)
    {
        return $this->json(['msms','emem']);
    }
}