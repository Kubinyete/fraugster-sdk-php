<?php

namespace Kubinyete\Fraugster\Model;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Country;
use Kubinyete\Fraugster\Type\Currency;
use Kubinyete\Fraugster\Type\Decimal;

class Seller implements JsonSerializable
{
    public function __construct(
        protected ?string $name,
        protected Currency $currency,
        protected Country $country,
        protected ?string $mcc = null,

    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(is_null($this->name) || strlen($this->name), "Seller name is required");
        DomainException::assert(is_null($this->mcc) || strlen($this->mcc) && preg_match('/^[0-9]$+/', $this->mcc), "Seller industry mcc is required");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'slr_crncy' => (string)$this->currency,
            'slr_ctry' => (string)$this->country,
            'slr_ind_mcc' => $this->mcc,
            'slr_name' => $this->name,
        ];
    }
}
