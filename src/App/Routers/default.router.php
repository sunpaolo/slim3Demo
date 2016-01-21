<?php
use \Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    echo "Hello";
    //print_r($this->get('view'));
    //print_r($this->logger);
    return $response;
});

$app->group('/v1/{c}/{a}', function () use ($app) {
    $app->map(['GET', 'POST'], '', 'App\Controllers\IndexController:index');
});
