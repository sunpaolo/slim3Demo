<?php
namespace Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;

/*
 * 自定义错误处理
 */
final class ApiError extends \Slim\Handlers\Error
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        $this->logger->critical($exception->getTraceAsString());
        //return parent::__invoke($request, $response, $exception);
        $output = json_encode([
            'error' => $exception->getMessage(),
            'code' => $exception->getCode()
        ]);

        $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
        $body->write($output);

        return $response
            ->withStatus(500)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);
    }
}