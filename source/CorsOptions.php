<?php

namespace Papimod\Cors;

use Papi\abstract\PapiOptions;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class CorsOptions extends PapiOptions
{
    public static function getPattern(): string
    {
        return '/{routes:.+}';
    }

    public function __invoke(Request $request, Response $response): Response
    {
        return $response;
    }
}
