<?php
namespace Tools\Middlewares;
/*
 * 参考：https://github.com/akrabat/rka-slim-session-middleware/blob/master/RKA/SessionMiddleware.php
 */
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class SessionMiddleware
{
    protected $options = [
        'name' => 'SESSID', //session name
        'lifetime' => 7200,
        'path' => null,
        'domain' => null,
        'secure' => false,
        'httponly' => true,
        'cache_limiter' => 'nocache'
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
        $this->start();
        return $next($request, $response);
    }

    /*
     * 开启session
     */
    private function start()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return;
        }

        $current = session_get_cookie_params();
        session_set_cookie_params(
            $this->options['lifetime'] ?: $current['lifetime'],
            $this->options['path'] ?: $current['path'],
            $this->options['domain'] ?: $current['domain'],
            $this->options['secure'],
            $this->options['httponly']
        );
        session_name($this->options['name']);
        session_cache_limiter($this->options['cache_limiter']);
        session_start();
        /*
         * 使用其它方式存储session
         */
        //$session = new \Lib\Session\MemcachedSession();
        //$session->start();
    }
}