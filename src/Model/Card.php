<?php

namespace Kubinyete\Fraugster\Model;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Currency;

class Card implements JsonSerializable
{
    public function __construct(
        protected string $bin,
        protected string $holder,
        protected string $lastFourDigits,
        protected string $expiryDate,
        protected ?string $num,
        protected ?string $numHash,
        protected ?string $numType = 'PAN',
    ) {
        $this->assertValid();
        $this->assertValidBin();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->bin), "Card bin is required");
        DomainException::assert(strlen($this->holder), "Card holder is required");
        DomainException::assert(strlen($this->lastFourDigits), "Card last four digits is required");
        DomainException::assert(strlen($this->expiryDate), "Card expiry date is required");
        DomainException::assert(strlen($this->num) || strlen($this->numHash), "Card num is required");
    }

    protected function assertValidBin(): void
    {
        DomainException::assert(preg_match('/^[0-9]{6}$/', $this->bin), "Card bin is supposed to have 6 digits");
    }

    protected function assertValidLastFourDigits(): void
    {
        DomainException::assert(preg_match('/^[0-9]{4}$/', $this->lastFourDigits), "Card last four digits is supposed to have 4 digits");
    }

    protected function assertValidExpiryDate(): void
    {
        DomainException::assert(preg_match('/^[0-9]{6}$/', $this->expiryDate), "Card expiry date is supposed to be in MMYYYY format");
    }

    protected function assertValidNum(): void
    {
        DomainException::assert(is_null($this->num) || preg_match('/^[0-9]{13-19}$/', $this->num), "Card num is supposed to have between 13 up to 19 digits");
    }

    protected function assertValidNumType(): void
    {
        DomainException::assert(in_array($this->num, ['PAN']), "Card num type is invalid");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'cc_bin' => $this->bin,
            'cc_cardholder' => $this->holder,
            'cc_exp_dt' => $this->expiryDate,
            'cc_exp_month' => substr($this->expiryDate, 0, 2),
            'cc_last_4_dig' => $this->lastFourDigits,
            'cc_num' => $this->num,
            'cc_num_hash' => $this->num ? null : $this->numHash,
            'cc_num_type' => $this->numType,
        ];
    }
}
