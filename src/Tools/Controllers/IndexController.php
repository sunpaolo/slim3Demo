<?php
namespace Tools\Controllers;

use Lib\BaseController;
use Lib\Util\Config;
use Respect\Validation\Validator;

class IndexController extends BaseController
{
    public function login($params)
    {
        $this->render('index.php', $params);
    }

    public function logout($params)
    {
        $this->render('login.php', $params);
    }

    public function index($params)
    {
        //$this->render('login.php', $params);
        $this->render('index.php', $params);
    }

}