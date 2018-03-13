<?php declare(strict_types=1);

namespace Ellipse\Middleware;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Middleware\Exceptions\ContainerMiddlewareTypeException;

class ContainerMiddleware implements MiddlewareInterface
{
    /**
     * The container.
     *
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * The container id to use to retrieve the middleware.
     *
     * @var string
     */
    private $id;

    /**
     * Set up a container middleware with the given container and id.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param string                            $id
     */
    public function __construct(ContainerInterface $container, string $id)
    {
        $this->container = $container;
        $this->id = $id;
    }

    /**
     * Get a middleware from the container then proxy its ->process() method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface  $request
     * @param \Psr\Http\Server\RequestHandlerInterface  $handler
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Ellipse\Middleware\Exceptions\ContainerMiddlewareTypeException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $middleware = $this->container->get($this->id);

        if ($middleware instanceof MiddlewareInterface) {

            return $middleware->process($request, $handler);

        }

        throw new ContainerMiddlewareTypeException($this->id, $middleware);
    }
}
