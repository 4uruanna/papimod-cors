<?php

namespace Papimod\Cors;

use Papi\interface\PapiMiddleware;
use Papimod\HttpError\HttpErrorMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Psr7\Factory\ResponseFactory;

final class CorsMiddleware implements PapiMiddleware
{
    private readonly ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public static function register(App $app, array &$middlewares_map): bool
    {
        return isset($middlewares_map[HttpErrorMiddleware::class]);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            $response = $this->responseFactory->createResponse();
        } else {
            $response = $handler->handle($request);
        }

        $response = $response
            ->withHeader("Access-Control-Allow-Origin", PAPI_CORS_ORIGIN)
            ->withHeader("Access-Control-Allow-Headers", PAPI_CORS_HEADERS)
            ->withHeader("Access-Control-Expose-Headers", PAPI_CORS_EXPOSE_HEADERS)
            ->withHeader("Access-Control-Allow-Methods", PAPI_CORS_METHODS)
            ->withHeader("Access-Control-Allow-Credentials", PAPI_CORS_CREDENTIALS)
            ->withHeader("Access-Control-Max-Age", PAPI_CORS_MAX_AGE)
            ->withHeader("Cache-Control", "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0")
            ->withHeader("Pragma", "no-cache");

        if (ob_get_contents()) {
            ob_clean();
        }

        return $response;
    }
}
