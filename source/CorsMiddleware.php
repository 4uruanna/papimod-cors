<?php

namespace Papimod\Cors;

use Papi\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;

final class CorsMiddleware implements Middleware
{
    private readonly ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public static function getPriority(): int
    {
        return (int) CORS_PRIORITY;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $is_options = $request->getMethod() === 'OPTIONS';
        $response = ($is_options ? $this->responseFactory->createResponse() : $handler->handle($request))
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', CORS_ORIGIN)
            ->withHeader('Access-Control-Allow-Headers', CORS_HEADERS)
            ->withHeader('Access-Control-Allow-Methods', CORS_METHODS)
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Pragma', 'no-cache');

        if (ob_get_contents()) {
            ob_clean();
        }

        return $response;
    }
}
