<?php

namespace Papimod\Cors;

use Papi\PapiModule;
use Papimod\Dotenv\DotEnvModule;
use Papimod\HttpError\HttpErrorModule;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

final class CorsModule extends PapiModule
{
    public static function getPrerequisites(): array
    {
        return [
            DotEnvModule::class,
            HttpErrorModule::class
        ];
    }

    public static function getDefinitions(): array
    {
        return [
            ResponseFactoryInterface::class => fn(ContainerInterface $c) => $c->get(ResponseFactory::class)
        ];
    }

    public static function getMiddlewares(): array
    {
        return [CorsMiddleware::class];
    }

    /**
     * Configure the module
     */
    public static function configure(): void
    {
        if (defined("PAPI_CORS_ORIGIN") === false) {
            $cors_origin = $_ENV["CORS_ORIGIN"] ?? "*";
            define("PAPI_CORS_ORIGIN", $cors_origin);
        }

        if (defined("PAPI_CORS_MAX_AGE") === false) {
            $cors_max_age = $_ENV["CORS_MAX_AGE"] ?? 3600;
            define("PAPI_CORS_MAX_AGE", $cors_max_age);
        }

        if (defined("PAPI_CORS_HEADERS") === false) {
            $cors_headers = $_ENV["CORS_HEADERS"] ?? "*";
            define("PAPI_CORS_HEADERS", $cors_headers);
        }

        if (defined("PAPI_CORS_METHODS") === false) {
            $cors_methods = $_ENV["CORS_METHODS"] ?? "GET, POST, PUT, PATCH, DELETE, OPTIONS";
            define("PAPI_CORS_METHODS", $cors_methods);
        }

        if (defined("PAPI_CORS_CREDENTIALS") === false) {
            $cors_credentials = $_ENV["CORS_CREDENTIALS"] ?? "true";
            define("PAPI_CORS_CREDENTIALS", $cors_credentials);
        }
    }
}
