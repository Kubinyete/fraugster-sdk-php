<?php

namespace Kubinyete\Fraugster\Model;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Country;
use Kubinyete\Fraugster\Type\Currency;
use Kubinyete\Fraugster\Type\State;

class Account implements JsonSerializable
{
    public function __construct(
        protected string $addressLine1,
        protected ?string $addressLine2,
        protected string $addressZip,
        protected string $addressCity,
        protected State $addressState,
        protected Country $addressCountry,
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->addressLine1), "Account address line 1 is required");
        DomainException::assert(strlen($this->addressZip), "Account address zip is required");
        DomainException::assert(strlen($this->addressCity), "Account address city is required");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'acct_ad_city' => $this->addressCity,
            'acct_ad_ctry' => (string)$this->addressCountry,
            'acct_ad_line1' => $this->addressLine1,
            'acct_ad_line2' => $this->addressLine2 ?? '',
            'acct_ad_state' => (string)$this->addressState,
            'acct_ad_zip' => $this->addressZip,
        ];
    }
}
