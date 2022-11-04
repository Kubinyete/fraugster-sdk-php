<?php

namespace Kubinyete\Fraugster\Model\Transaction\Sync;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;

class DeclinedUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
        ?string $issuerDeclineReason,
        ?string $issuerReasonCode,
    ) {
        // DomainException::assert(!is_null($issuerDeclineReason) || !is_null($issuerReasonCode), "Either issuer_decline_reason or issuer_reason_code should be sent");

        parent::__construct($id, TransactionStatus::Declined, $ts, [
            'issuer_decline_reason' => $issuerDeclineReason,
            'issuer_reason_code' => $issuerReasonCode,
        ]);
    }
}
