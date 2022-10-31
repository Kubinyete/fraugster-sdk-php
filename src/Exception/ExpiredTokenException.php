<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class ExpiredTokenException extends Exception
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "Informed token is expired and cannot be used.", $code, $previous);
    }
}
