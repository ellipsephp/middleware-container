<?php declare(strict_types=1);

namespace Ellipse\Middleware\Exceptions;

use TypeError;

use Psr\Http\Server\MiddlewareInterface;

class ContainedMiddlewareTypeException extends TypeError implements ContainerMiddlewareExceptionInterface
{
    public function __construct(string $id, $value)
    {
        $template = "The value contained in the '%s' entry of the container is of type %s - object implementing %s expected";

        $type = is_object($value) ? get_class($value) : gettype($value);

        $msg = sprintf($template, $id, $type, MiddlewareInterface::class);

        parent::__construct($msg);
    }
}
