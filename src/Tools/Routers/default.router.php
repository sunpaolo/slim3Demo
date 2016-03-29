<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->any('/[{controller}/{action}]', function (Request $request, Response $response, $args) {
    $controller = $args['controller'] ?: 'index';
    $action = $args['action'] ?: 'index';
    $className = 'Tools\\Controllers\\' . ucfirst($controller) . 'Controller';
    if (class_exists($className, true) && is_callable([$className, $action], false)) {
        $class = new $className($this);
        $params = $request->getQueryParams();
        if ($request->isPost()) {
            $params = $request->getParsedBody();
        }
        return $class->$action($params);
    } else {
        throw new Exception('Error Path');
    }
})->add(new \App\Middlewares\AuthMiddleware());