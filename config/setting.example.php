<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('log_errors', true);
ini_set('html_errors', true);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//error_reporting(E_ALL ^ E_NOTICE);
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        // View settings
        'view' => [
            'template_path' => APP_DIR . '/views',
            'twig' => [
                'cache' => BASE_DIR . '/storage/cache',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        // Monolog settings
        'logger' => [
            'name' => 'app',
            'path' => BASE_DIR . '/storage/log/' . date('Y-m-d') . '.log',
        ],
    ],
];