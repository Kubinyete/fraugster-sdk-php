<?php

namespace Kubinyete\Fraugster\Model;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Country;
use Kubinyete\Fraugster\Type\Currency;
use Kubinyete\Fraugster\Type\State;
use Kubinyete\Fraugster\Util\StringUtil;

class Billing implements JsonSerializable
{
    public function __construct(
        protected string $addressLine1,
        protected ?string $addressLine2,
        protected ?string $addressLine3,
        protected ?string $houseNumber,
        protected string $addressZip,
        protected string $addressCity,
        protected State $addressState,
        protected Country $addressCountry,
        protected string $addressName,
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->addressLine1), "Billing address line 1 is required");
        DomainException::assert(strlen($this->addressZip), "Billing address zip is required");
        DomainException::assert(strlen($this->addressCity), "Billing address city is required");
        DomainException::assert(strlen($this->addressName), "Billing address name is required");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'bill_ad_city' => $this->addressCity,
            // 'bill_ad_city_norm_dp' => StringUtil::normalizeLower($this->addressCity),
            'bill_ad_ctry' => (string)$this->addressCountry,
            // 'bill_ad_ctry_norm_dp' => StringUtil::normalizeUpper((string)$this->addressCountry),
            'bill_ad_line1' => $this->addressLine1,
            // 'bill_ad_line1_norm_dp' => StringUtil::normalizeLower($this->addressLine1),
            'bill_ad_line2' => $this->addressLine2 ?? '',
            // 'bill_ad_line2_norm_dp' => StringUtil::normalizeLower($this->addressLine2 ?? ''),
            'bill_ad_line3' => $this->addressLine3 ?? '',
            // 'bill_ad_line3_norm_dp' => StringUtil::normalizeLower($this->addressLine3 ?? ''),
            'bill_ad_state' => (string)$this->addressState,
            // 'bill_ad_state_norm_dp' => StringUtil::normalizeUpper((string)$this->addressState),
            'bill_ad_zip' => $this->addressZip,
            // 'bill_ad_zip_norm_dp' => StringUtil::normalizeLower($this->addressZip),

            'bill_ad_house_num' => $this->houseNumber,
            // 'bill_ad_house_num_norm_dp' => StringUtil::normalizeUpper($this->houseNumber),
            'bill_ad_name' => $this->addressName,
        ];
    }
}
