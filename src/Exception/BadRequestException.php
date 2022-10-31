<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class BadRequestException extends ServerException
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "Request is unacceptable, missing required parameters (400 Bad request).", $code, $previous);
    }
}
