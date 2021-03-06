<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// php-view
$container['view'] = function ($c) {
    return new Slim\Views\PhpRenderer($c['settings']['view']['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $logger = new Monolog\Logger($c['settings']['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\MemoryPeakUsageProcessor());
    $logger->pushProcessor(new Monolog\Processor\WebProcessor());
    $handler = new Monolog\Handler\StreamHandler($c['settings']['logger']['path'], \Monolog\Logger::DEBUG);
    $handler->setFormatter(new Monolog\Formatter\JsonFormatter());
    $logger->pushHandler($handler);
    $logger->pushHandler(new Monolog\Handler\ErrorLogHandler());
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