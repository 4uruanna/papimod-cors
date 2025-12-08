<?php

namespace Papimod\Cors;

use Papi\ApiModule;
use Papimod\Dotenv\DotEnvModule;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

final class CorsModule extends ApiModule
{
    public function __construct()
    {
        $this->prerequisite_list = [DotEnvModule::class];

        $this->definition_list = [
            ResponseFactoryInterface::class
            => fn(ContainerInterface $container) => $container->get(ResponseFactory::class)
        ];

        $this->middleware_list = [CorsMiddleware::class];
    }

    public function configure(): void
    {
        if (defined("CORS_PRIORITY") === false) {
            define("CORS_PRIORITY", $_SERVER["CORS_PRIORITY"] ?? 128);
        }

        if (defined("CORS_ORIGIN") === false) {
            define("CORS_ORIGIN", $_SERVER["CORS_ORIGIN"] ?? "*");
        }

        if (defined("CORS_HEADERS") === false) {
            define("CORS_HEADERS", $_SERVER["CORS_HEADERS"] ?? "*");
        }

        if (defined("CORS_METHODS") === false) {
            define("CORS_METHODS", $_SERVER["CORS_METHODS"] ?? "GET, POST, PUT, PATCH, DELETE, OPTIONS, HEAD");
        }
    }
}
