<?php

namespace Papimod\Cors\Test;

use Papi\ApiBuilder;
use Papi\enumerator\HttpMethod;
use Papi\PapiBuilder;
use Papi\Test\ApiBaseTestCase;
use Papi\Test\foo\actions\FooAction;
use Papi\Test\mock\FooGet;
use Papi\Test\PapiTestCase;
use Papimod\Common\CommonModule;
use Papimod\Cors\CorsModule;
use Papimod\Dotenv\DotEnvModule;
use Papimod\HttpError\HttpErrorModule;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;

#[CoversClass(CorsModule::class)]
#[Small]
final class CorsModuleTest extends PapiTestCase
{
    public function testLoadModule(): void
    {
        define("PAPI_DOTENV_DIRECTORY", __DIR__);
        define("PAPI_DOTENV_FILE", ".test.env");

        $request = $this->createRequest(HttpMethod::GET, '/');
        $builder = new PapiBuilder();
        $app = $builder
            ->addModule(
                DotEnvModule::class,
                CommonModule::class,
                HttpErrorModule::class,
                CorsModule::class
            )
            ->addAction(FooGet::class)
            ->build();

        var_dump($app);

        $response = $app->handle($request);
        $headers = $response->getHeaders();

        // var_dump($headers);
        $this->assertArrayHasKey("Access-Control-Allow-Credentials", $headers);
        $this->assertEquals('true', $headers["Access-Control-Allow-Credentials"][0]);

        $this->assertArrayHasKey("Access-Control-Allow-Origin", $headers);
        $this->assertEquals(PAPI_CORS_ORIGIN, $headers["Access-Control-Allow-Origin"][0]);

        $this->assertArrayHasKey("Access-Control-Allow-Headers", $headers);
        $this->assertEquals(PAPI_CORS_HEADERS, $headers["Access-Control-Allow-Headers"][0]);

        $this->assertArrayHasKey("Access-Control-Allow-Methods", $headers);
        $this->assertEquals(PAPI_CORS_METHODS, $headers["Access-Control-Allow-Methods"][0]);
    }
}
