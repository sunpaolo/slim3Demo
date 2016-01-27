<?php
# include the composer autoloader
include __DIR__ . '/../vendor/autoload.php';

//定义整个项目的根目录
define('BASE_DIR', realpath(__DIR__.'/../'));

//定义应用程序根目录
define('APP_DIR', BASE_DIR . '/src/App');

//定义默认字符集
mb_internal_encoding('UTF-8');

//定义默认时区
date_default_timezone_set('UTC');