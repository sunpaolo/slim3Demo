<?php
namespace App\Controllers;

use Lib\BaseController;
use Lib\Util\Config;
use Respect\Validation\Validator;

class IndexController extends BaseController
{
    public function index($params)
    {
        $this->render('index.php', []);
    }

}