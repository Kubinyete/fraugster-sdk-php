<?php

namespace Kubinyete\Fraugster\Model\Exception;

use DomainException as GlobalDomainException;
use Throwable;

class DomainException extends GlobalDomainException
{
    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? "Input data is invalid.", $code, $previous);
    }

    //

    public static function assert(mixed $condition, ?string $message): void
    {
        if (!$condition) {
            throw new self($message);
        }
    }
}
