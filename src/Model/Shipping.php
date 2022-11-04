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

class Shipping implements JsonSerializable
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
        protected ?string $comments,
    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->addressLine1), "Shipping address line 1 is required");
        DomainException::assert(strlen($this->addressZip), "Shipping address zip is required");
        DomainException::assert(strlen($this->addressCity), "Shipping address city is required");
        DomainException::assert(strlen($this->addressName), "Shipping address name is required");
        DomainException::assert(strlen(is_null($this->comments) || strlen($this->comments)), "Shipping comments is required");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'ship_ad_city' => $this->addressCity,
            // 'ship_ad_city_norm_dp' => StringUtil::normalizeLower($this->addressCity),
            'ship_ad_ctry' => (string)$this->addressCountry,
            // 'ship_ad_ctry_norm_dp' => StringUtil::normalizeUpper((string)$this->addressCountry),
            'ship_ad_line1' => $this->addressLine1,
            // 'ship_ad_line1_norm_dp' => StringUtil::normalizeLower($this->addressLine1),
            'ship_ad_line2' => $this->addressLine2 ?? '',
            // 'ship_ad_line2_norm_dp' => StringUtil::normalizeLower($this->addressLine2 ?? ''),
            'ship_ad_line3' => $this->addressLine3 ?? '',
            // 'ship_ad_line3_norm_dp' => StringUtil::normalizeLower($this->addressLine3 ?? ''),
            'ship_ad_state' => (string)$this->addressState,
            // 'ship_ad_state_norm_dp' => StringUtil::normalizeUpper((string)$this->addressState),
            'ship_ad_zip' => $this->addressZip,
            // 'ship_ad_zip_norm_dp' => StringUtil::normalizeLower($this->addressZip),

            'ship_ad_house_num' => $this->houseNumber,
            // 'ship_ad_house_num_norm_dp' => StringUtil::normalizeUpper($this->houseNumber),
            'ship_ad_name' => $this->addressName,
            'ship_comments' => $this->comments,
        ];
    }
}
