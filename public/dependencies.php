<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(
        $c['settings']['view']['template_path'],
        $c['settings']['view']['twig']
    );
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));
    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $logger = new \Monolog\Logger($c['settings']['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\WebProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($c['settings']['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// error handler
$container['errorHandler'] = function ($c) {
    return new Lib\ApiError($c['logger']);
};

// not found handler
$container['notFoundHandler'] = function ($c) {
    return new Lib\ApiNotFound($c['logger']);
};

// not allowed handler
$container['notAllowedHandler'] = function ($c) {
    return new Lib\ApiNotAllowed($c['logger']);
};