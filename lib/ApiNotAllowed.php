<?php
namespace Lib;

use Slim\Handlers\NotAllowed;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;

class ApiNotAllowed extends NotAllowed
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, array $methods)
    {
        $msg = 'Method must be one of: ' . implode(', ', $methods);

        $this->logger->alert($msg);

        $output = json_encode([
            'error' => $msg,
            'code' => 405
        ]);

        $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
        $body->write($output);

        return $response
            ->withStatus(405)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);
    }
}