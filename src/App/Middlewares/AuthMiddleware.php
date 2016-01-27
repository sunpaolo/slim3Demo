<?php
namespace App\Middlewares;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

/*
 * 验证token是否合法
 */
class AuthMiddleware
{
    //不验证token的route
    private $excludedRoute = [
        'index/index',
        'index/login'
    ];

    public function __construct()
    {

    }

    /**
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        // before
        $route = $request->getUri()->getPath();
        if (!in_array($route, $this->excludedRoute)) {
            if ($this->checkToken($request)) {
                $output = json_encode([
                    'error' => 'Invalid token',
                    'code' => 405
                ]);
                return $response
                    ->withStatus(405)
                    ->withHeader('Content-type', 'application/json')
                    ->write($output);
            }
        }
        $newResponse = $next($request, $response);
        // after
        return $newResponse;
    }

    /*
     * 验证token
     */
    private function checkToken(ServerRequestInterface $request)
    {
        $params = $request->getQueryParams();
        if ($request->isPost()) {
            $params = $request->getParsedBody();
        }
        $token = $params['token'] ?: '';
        return false;
    }
}