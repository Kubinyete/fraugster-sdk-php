<?php

namespace Kubinyete\Fraugster\Type;

use DomainException as GlobalDomainException;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use League\ISO3166\ISO3166;

class Country implements JsonSerializable
{
    public function __construct(
        protected string $value
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        $country = (new ISO3166())->alpha2($this->value);
        DomainException::assert($country, "Value $this->value is not a valid alpha-2 country code");
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
