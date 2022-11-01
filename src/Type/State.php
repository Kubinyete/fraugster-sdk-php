<?php

namespace Kubinyete\Fraugster\Type;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class State implements JsonSerializable
{
    public function __construct(
        protected string $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->value) == 2, "Value $this->value is not a valid alpha-2 state code");
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
