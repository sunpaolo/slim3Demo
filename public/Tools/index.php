<?php
include __DIR__ . '/../common.php';

//定义应用程序根目录
define('APP_DIR', BASE_DIR . '/src/Tools');

$config = include BASE_DIR . '/config/setting.php';
$app = new Slim\App($config);

//加载依赖服务
include __DIR__ . '/../dependencies.php';

//加载中间件
$middlewares = glob(APP_DIR . '/Middlewares/*.php');
foreach ($middlewares as $middleware) {
    include $middleware;
}
unset($middleware, $middlewares);

//加载路由配置
$routers = glob(APP_DIR . '/Routers/*.router.php');
foreach ($routers as $route) {
    include $route;
}
unset($route, $routers);

$app->run();