<?php

namespace Kubinyete\Fraugster\Type;

use DomainException as GlobalDomainException;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use League\ISO3166\ISO3166;

class Decimal implements JsonSerializable
{
    public function __construct(
        protected float $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert($this->value >= 0.0, "Decimal value should not be a negative number");
    }

    public function getValue(): float
    {
        return $this->value;
    }

    //

    public function __toString()
    {
        return number_format($this->value, 2, '.', '');
    }

    public function jsonSerialize(): mixed
    {
        return (string)$this;
    }
}
