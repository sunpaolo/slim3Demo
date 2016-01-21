<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Lib\BaseController;

class IndexController extends BaseController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        //$this->json(['test' => 1]);
        $this->render('abc/index.php', ['st' => 1]);
    }
}