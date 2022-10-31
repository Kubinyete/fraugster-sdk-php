<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class UnauthorizedException extends ServerException
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "You don't have permission to access this resource (401 Unathorized).", $code, $previous);
    }
}
