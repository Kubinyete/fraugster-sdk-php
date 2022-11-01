<?php

namespace Kubinyete\Fraugster\Type;

use Alcohol\ISO4217;
use DomainException as GlobalDomainException;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class Currency implements JsonSerializable
{
    public function __construct(
        protected string $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        try {
            (new ISO4217())->getByAlpha3($this->value);
        } catch (GlobalDomainException) {
            DomainException::assert(false, "Value $this->value is not a valid alpha-3 currency code");
        }
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
