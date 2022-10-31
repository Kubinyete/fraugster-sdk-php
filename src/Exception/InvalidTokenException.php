<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class InvalidTokenException extends Exception
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "Token is not usable or has incorrect format.", $code, $previous);
    }
}
