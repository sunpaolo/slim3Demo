<?php
namespace Lib;

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

    public function json($data, $wrap = true)
    {
        if ($wrap) {
            $data = ['data' => $data];
        }
        return $this->response
            ->withStatus(200)
            ->withHeader('Content-type', 'application/json; charset=utf-8')
            ->write(json_encode($data));
    }

    public function render($template, array $data)
    {
        $this->view->render($this->response, $template, $data);
    }

    public function renderTemplate($template, array $data)
    {
        $tplData = [
            'menu' => $this->view->fetch('layout/menu.php', []),
            'content' => $this->view->fetch($template, $data),
        ];
        $this->view->render($this->response, 'layout/default.php', $tplData);
    }
}