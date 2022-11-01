<?php

namespace Kubinyete\Fraugster\Type;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class IpAddress implements JsonSerializable
{
    public function __construct(
        protected string $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(filter_var($this->value, FILTER_VALIDATE_IP), "Value $this->value is not a valid ip address");
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
