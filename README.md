# Middleware container

[Psr-15 middleware](https://www.php-fig.org/psr/psr-15/) proxying a [Psr-11 container](https://www.php-fig.org/psr/psr-11/) entry.

**Require** php >= 7.0

**Installation** `composer require ellipse/middleware-container`

**Run tests** `./vendor/bin/kahlan`

- [Getting started](https://github.com/ellipsephp/middleware-container#getting-started)

## Getting started

The class ```Ellipse\Middleware\ContainerMiddleware``` takes an implementation of `Psr\Container\ContainerInterface` and a container alias as parameter. Its `->process()` method retrieve a middleware from the container using this alias and proxy its `->process()` method.

An `Ellipse\Middleware\Exceptions\ContainerMiddlewareTypeException` is thrown when the value retrieved from the container is not an object implementing `Psr\Http\Server\MiddlewareInterface`.

```php
<?php

namespace App;

use SomePsr11Container;

use Ellipse\Middleware\ContainerMiddleware;

// Get some Psr-11 container.
$container = new SomePsr11Container;

// Add a middleware in the container.
$container->set('some.middleware', function () {

    return new SomeMiddleware;

});

// Create a container middleware with the Psr-11 container and the middleware alias.
$middleware = new ContainerMiddleware($container, 'some.middleware');

// The middleware ->process() method retrieve the middleware from the container and proxy it.
$response = $middleware->process($request, $handler);
```
