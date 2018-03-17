<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Middleware\ContainerMiddleware;
use Ellipse\Middleware\Exceptions\ContainedMiddlewareTypeException;

describe('ContainerMiddleware', function () {

    beforeEach(function () {

        $this->container = mock(ContainerInterface::class);

        $this->middleware = new ContainerMiddleware($this->container->get(), 'SomeMiddleware');

    });

    it('should implement MiddlewareInterface', function () {

        expect($this->middleware)->toBeAnInstanceOf(MiddlewareInterface::class);

    });

    describe('->process()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();
            $this->response = mock(ResponseInterface::class)->get();

            $this->handler = mock(RequestHandlerInterface::class)->get();

        });

        context('when the value retrieved from the container is an object implementing MiddlewareInterface', function () {

            it('should proxy the middleware ->process() method', function () {

                $middleware = mock(MiddlewareInterface::class);

                $this->container->get->with('SomeMiddleware')->returns($middleware);

                $middleware->process->with($this->request, $this->handler)->returns($this->response);

                $test = $this->middleware->process($this->request, $this->handler);

                expect($test)->toBe($this->response);

            });

        });

        context('when the value retrieved from the container is not an object implementing MiddlewareInterface', function () {

            it('should throw a ContainedMiddlewareTypeException', function () {

                $this->container->get->with('SomeMiddleware')->returns('middleware');

                $test = function () {

                    $this->middleware->process($this->request, $this->handler);

                };

                $exception = new ContainedMiddlewareTypeException('SomeMiddleware', 'middleware');

                expect($test)->toThrow($exception);

            });

        });

    });

});
