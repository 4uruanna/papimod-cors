
# CORS Papi Module

![]( https://img.shields.io/badge/php-8.5-777BB4?logo=php)
![]( https://img.shields.io/badge/composer-2-885630?logo=composer)

## Description

Help setting up [cross-origin resource sharing](https://developer.mozilla.org/en-US/docs/Web/HTTP/Guides/CORS) in your [papi]().

This module is based on the [official tutorial](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html).

## Configuration

### `CORS_PRIORITY` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | int                                               |
|Description    | Set the priority of the middleware                |
|Default        | `128`                                             |

### `CORS_ORIGIN` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Origin_                 |
|Default        | `*`                                               |

### `CORS_HEADERS` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Headers_                |
|Default        | `*`                                               |

### `CORS_METHODS` (.ENV)

|               |                                                   |
|-:             |:-                                                 |
|Required       | No                                                |
|Type           | string                                            |
|Description    | Set _Access-Control-Allow-Methods_                |
|Default        | `GET, POST, PUT, PATCH, DELETE, OPTIONS, HEAD`    |