<?php

namespace Kubinyete\Fraugster\Exception;

use Throwable;

class ParseException extends Exception
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "Data cannot be parsed.", $code, $previous);
    }
}
