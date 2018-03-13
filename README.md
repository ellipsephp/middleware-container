# Middleware container

This package provides a [Psr-15](https://www.php-fig.org/psr/psr-15/) middleware proxying a [Psr-11](https://www.php-fig.org/psr/psr-11/) container entry.

**Require** php >= 7.0

**Installation** `composer require ellipse/middleware-container`

**Run tests** `./vendor/bin/kahlan`

- [Using container entries as middleware](#using-container-entries-as-middleware)
- [Example using auto wiring](#example-using-auto-wiring)

## Using container entries as middleware

The class `Ellipse\Middleware\ContainerMiddleware` takes an implementation of `Psr\Container\ContainerInterface` and a container id as parameters. Its `->process()` method retrieve a middleware from the container using this id and proxy its `->process()` method.

It can be useful in situations the container entry should be resolved at the time the request is processed.

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

// Create a container middleware with the Psr-11 container and the entry id.
$middleware = new ContainerMiddleware($container, 'some.middleware');

// The middleware ->process() method retrieve the middleware from the container and proxy it.
$response = $middleware->process($request, new SomeRequestHandler);
```

## Example using auto wiring

It can be cumbersome to register every middleware in the container. Here is how to auto wire middleware classes using the `Ellipse\Container\ReflectionContainer` class from the [ellipse/container-reflection](https://github.com/ellipsephp/container-reflection) package.

```php
<?php

namespace App;

use SomePsr11Container;

use Ellipse\Container\ReflectionContainer;
use Ellipse\Middleware\ContainerMiddleware;

// Get some Psr-11 container.
$container = new SomePsr11Container;

// Decorate the container with a reflection container.
$container = new ReflectionContainer($container);

// Create a container middleware with the Psr-11 container and a middleware class name.
$middleware = new ContainerMiddleware($container, SomeMiddleware::class);

// A new instance of SomeMiddleware is built and its ->process() method is proxied.
$response = $middleware->process($request, new SomeRequestHandler);
```
