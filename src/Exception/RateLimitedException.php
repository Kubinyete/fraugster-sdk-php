<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class RateLimitedException extends ServerException
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "You have been rate limited (429 Too many requests).", $code, $previous);
    }
}
