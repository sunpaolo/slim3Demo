<?php
include __DIR__ . '/../common.php';

//定义应用程序根目录
define('APP_DIR', BASE_DIR . '/src/Tools');

$app = new Slim\App();

//加载路由配置
$routers = glob(APP_DIR . '/Routers/*.router.php');
foreach ($routers as $route) {
    include $route;
}
unset($route, $routers);

$app->run();