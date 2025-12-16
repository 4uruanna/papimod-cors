<?php

namespace Papimod\Cors;

use Papi\ApiModule;
use Papimod\Dotenv\DotEnvModule;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

final class CorsModule extends ApiModule
{
    public const DEFAULT_PRIORITY = 128;
    public const DEFAULT_ORIGIN = "*";
    public const DEFAULT_HEADERS = "*";
    public const DEFAULT_METHODS = "GET, POST, PUT, PATCH, DELETE, OPTIONS, HEAD";

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
        $this->defineCorsPriority();
        $this->defineCorsOrigin();
        $this->defineCorsHeaders();
        $this->defineCorsMethods();
    }

    public function defineCorsPriority(): void
    {
        if (defined("CORS_PRIORITY") === false) {
            $priority = self::DEFAULT_PRIORITY;

            if (isset($_SERVER["CORS_PRIORITY"])) {
                $priority = $_SERVER["CORS_PRIORITY"];
            }

            define("CORS_PRIORITY", $priority);
        }

        $_SERVER["CORS_PRIORITY"] = CORS_PRIORITY;
    }

    public function defineCorsOrigin(): void
    {
        if (defined("CORS_ORIGIN") === false) {
            $origin = self::DEFAULT_ORIGIN;

            if (isset($_SERVER["CORS_ORIGIN"])) {
                $origin = $_SERVER["CORS_ORIGIN"];
            }

            define("CORS_ORIGIN", $origin);
        }

        $_SERVER["CORS_ORIGIN"] = CORS_ORIGIN;
    }

    public function defineCorsHeaders(): void
    {
        if (defined("CORS_HEADERS") === false) {
            $headers = self::DEFAULT_HEADERS;

            if (isset($_SERVER["CORS_HEADERS"])) {
                $headers = $_SERVER["CORS_HEADERS"];
            }

            define("CORS_HEADERS", $headers);
        }

        $_SERVER["CORS_HEADERS"] = CORS_HEADERS;
    }

    public function defineCorsMethods(): void
    {
        if (defined("CORS_METHODS") === false) {
            $methods = self::DEFAULT_METHODS;

            if (isset($_SERVER["CORS_METHODS"])) {
                $methods = $_SERVER["CORS_METHODS"];
            }

            define("CORS_METHODS", $methods);
        }

        $_SERVER["CORS_METHODS"] = CORS_METHODS;
    }
}
