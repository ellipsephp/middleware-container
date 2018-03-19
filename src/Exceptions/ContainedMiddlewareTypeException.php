<?php declare(strict_types=1);

namespace Ellipse\Middleware\Exceptions;

use TypeError;

use Psr\Http\Server\MiddlewareInterface;

use Ellipse\Exceptions\ContainerEntryTypeErrorMessage;

class ContainedMiddlewareTypeException extends TypeError implements ContainerMiddlewareExceptionInterface
{
    public function __construct(string $id, $value)
    {
        $msg = new ContainerEntryTypeErrorMessage($id, $value, MiddlewareInterface::class);

        parent::__construct((string) $msg);
    }
}
