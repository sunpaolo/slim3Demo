<?php
namespace Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Slim\Views\Twig;

abstract class BaseController
{
    protected $view;
    protected $logger;
    protected $request;
    protected $response;

    public function __construct(\Slim\Container $container)
    {
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
        $this->request = $container->request;
        $this->response = $container->response;
    }

    public function json($data)
    {
        $this->response
            ->withStatus(200)
            ->withHeader('Content-type', 'application/json; charset=utf-8')
            ->write(json_encode($data));
    }

    public function render($template, array $data)
    {
        $this->view->render($this->response, $template, $data);
    }
}