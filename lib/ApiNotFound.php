<?php
namespace Lib;

use Slim\Handlers\NotFound;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;

class ApiNotFound extends NotFound
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response)
    {
        $msg = 'Not Found : ' . $request->getUri()->__toString();

        $this->logger->alert($msg);

        $output = json_encode([
            'error' => $msg,
            'code' => 404
        ]);

        $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
        $body->write($output);

        return $response
            ->withStatus(404)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);
    }
}