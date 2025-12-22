
# CORS Papi Module

![]( https://img.shields.io/badge/php-8.5-777BB4?logo=php)
![]( https://img.shields.io/badge/composer-2-885630?logo=composer)

## Description

Help setting up [cross-origin resource sharing](https://developer.mozilla.org/en-US/docs/Web/HTTP/Guides/CORS) in your [papi](https://github.com/4uruanna/papi).

This module is based on the [official tutorial](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html).

## Prerequisites Modules

- [Dotenv](https://github.com/4uruanna/papimod-dotenv)
- [Http Error](https://github.com/4uruanna/papimod-http-error)

## Configuration

### `CORS_ORIGIN` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Origin_                 |
|Default        | `*`                                               |

### `CORS_METHODS` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Methods_                |
|Default        | `GET, POST, PUT, PATCH, DELETE, OPTIONS`          |

### `CORS_MAX_AGE` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Max-Age_                      |
|Default        | 3600                                              |

### `CORS_HEADERS` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Headers_                |
|Default        | `*`                                               |

### `CORS_EXPOSE_HEADERS` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Expose-Headers_               |
|Default        | `*`                                               |


## Usage

You can add the following options to your  `.env` file:

```.env
CORS_PRIORITY=1
CORS_ORIGIN=plop.fr
CORS_HEADERS="Content-Type, x-requested-with"
CORS_EXPOSE_HEADERS="Content-Encoding, Foo-Bar"
CORS_METHODS="GET, POST, PUT, PATCH, DELETE, OPTIONS, HEAD"
```

Import the module when creating your application:

```php
require __DIR__ . "/../vendor/autoload.php";

use Papi\PapiBuilder;
use Papimod\Dotenv\DotEnvModule;
use Papimod\Common\CommonModule;
use Papimod\HttpError\HttpErrorModule;
use Papimod\Cors\CorsModule;
use function DI\create;

$builder = new PapiBuilder();

$builder
    ->setModule(
        DotEnvModule::class, # Prerequisite
        CommonModule::class, # Prerequisite of HttpErrorModule
        HttpErrorModule::class, # Prerequisite
        CorsModule::class
    )
    ->build()
    ->run();
```

## MDN Recommendations

- The server must not specify the `*` wildcard for the `Access-Control-Allow-Origin` response-header value, but must instead specify an explicit origin; for example: `Access-Control-Allow-Origin: https://example.com`

- The server must not specify the `*` wildcard for the `Access-Control-Allow-Headers` response-header value, but must instead specify an explicit list of header names; for example, `Access-Control-Allow-Headers: X-PINGOTHER, Content-Type`

- The server must not specify the `*` wildcard for the `Access-Control-Allow-Methods` response-header value, but must instead specify an explicit list of method names; for example, `Access-Control-Allow-Methods: POST, GET`

- The server must not specify the `*` wildcard for the `Access-Control-Expose-Headers` response-header value, but must instead specify an explicit list of header names; for example, `Access-Control-Expose-Headers: Content-Encoding, Kuma-Revision`