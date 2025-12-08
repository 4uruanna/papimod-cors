<?php

namespace Papimod\Cors\Test;

use Papi\ApiBuilder;
use Papi\Test\ApiBaseTestCase;
use Papi\Test\foo\actions\FooAction;
use Papimod\Cors\CorsModule;
use Papimod\Dotenv\DotEnvModule;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;

#[CoversClass(CorsModule::class)]
#[Small]
final class CorsModuleTest extends ApiBaseTestCase
{
    public function testLoadModule(): void
    {
        define("ENVIRONMENT_DIRECTORY", __DIR__);
        define("ENVIRONMENT_FILE", ".test.env");

        $request = $this->createRequest('GET', '/foo');

        $response = ApiBuilder::getInstance()
            ->setModules([
                DotEnvModule::class,
                CorsModule::class
            ])
            ->setActions([FooAction::class])
            ->build()
            ->handle($request);

        $headers = $response->getHeaders();
        $this->assertArrayHasKey("Access-Control-Allow-Credentials", $headers);
        $this->assertArrayHasKey("Access-Control-Allow-Origin", $headers);
        $this->assertArrayHasKey("Access-Control-Allow-Headers", $headers);
        $this->assertArrayHasKey("Access-Control-Allow-Methods", $headers);
    }
}
