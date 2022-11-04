<?php

namespace Kubinyete\Fraugster\Model\Recommendation;

use JsonSerializable;
use Kubinyete\Fraugster\Util\ArrayUtil;
use TypeError;

class Recommendation implements JsonSerializable
{
    public function __construct(
        protected ApprovedStatus $fraugsterApproved,
        protected string $fraugsterTransactionId,
        protected bool $isLiable,
        protected ?LiabilityReason $liabilityReason,
        protected float $score,
        protected ?array $validation,
        protected ?array $evidence,
        protected ?string $fraugsterDeviceId,

    ) {
    }

    public function fraugsterApproved(): ApprovedStatus
    {
        return $this->fraugsterApproved;
    }

    public function frgTransId(): string
    {
        return $this->fraugsterTransactionId;
    }

    public function isLiable(): bool
    {
        return $this->isLiable;
    }

    public function liabilityReason(): ?LiabilityReason
    {
        return $this->liabilityReason;
    }

    public function score(): float
    {
        return $this->score;
    }

    public function validation(): ?array
    {
        return $this->validation;
    }

    public function evidence(): ?array
    {
        return $this->evidence;
    }

    public function frgDeviceId(): ?string
    {
        return $this->fraugsterDeviceId;
    }

    //

    public static function tryParse(array $data): ?static
    {
        try {
            return new static(
                ApprovedStatus::from(ArrayUtil::get('fraugster_approved', $data)),
                ArrayUtil::get('frg_trans_id', $data),
                ArrayUtil::get('is_liable', $data, false),
                LiabilityReason::tryFrom(ArrayUtil::get('liability_reason', $data)),
                ArrayUtil::get('score', $data),
                ArrayUtil::get('validation', $data),
                ArrayUtil::get('evidence', $data),
                ArrayUtil::get('frg_device_id', $data),
            );
        } catch (TypeError $e) {
            return null;
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
