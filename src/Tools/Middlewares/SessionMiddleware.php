<?php
namespace Tools\Middlewares;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class SessionMiddleware
{
    protected $options = [
        'name' => 'SID',
        'lifetime' => 86400,
        'path' => null,
        'domain' => null,
        'secure' => false,
        'httponly' => true,
    ];

    public function __construct($options = [])
    {
        $keys = array_keys($this->options);
        foreach ($keys as $key) {
            if (array_key_exists($key, $options)) {
                $this->options[$key] = $options[$key];
            }
        }
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->sessionStart();
        return $next($request, $response);
    }

    /*
     * 开启session
     */
    private function sessionStart()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return;
        }
        session_set_cookie_params(
            $this->options['lifetime'],
            $this->options['path'],
            $this->options['domain'],
            $this->options['secure'],
            $this->options['httponly']
        );
        session_name($this->options['name']);
        session_cache_limiter(false);
        session_start();
    }
}