<?php

namespace Kubinyete\Fraugster\Model;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class Email implements JsonSerializable
{
    public function __construct(
        protected string $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(filter_var($this->value, FILTER_VALIDATE_EMAIL), "Value $this->value is not a valid email address");
    }

    //

    public function __toString()
    {
        return $this->value;
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
