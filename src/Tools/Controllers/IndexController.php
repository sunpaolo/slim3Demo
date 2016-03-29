<?php
namespace Tools\Controllers;

use Lib\BaseController;
use Lib\Util\Config;
use Respect\Validation\Validator;

class IndexController extends BaseController
{
    public function login($params)
    {
        $account = $params['account'] ?: '';
        $password = $params['password'] ?: '';
        $remember = $params['remember'] ?: '';
        if () {
            $this->renderTemplate('login.php', $params);
        }
        $this->renderTemplate('index.php', $params);
    }

    public function logout($params)
    {

        $this->render('login.php', $params);
    }

    public function index($params)
    {
        //$this->render('login.php', $params);
        if () {

        }
        $this->renderTemplate('index.php', $params);
    }

}