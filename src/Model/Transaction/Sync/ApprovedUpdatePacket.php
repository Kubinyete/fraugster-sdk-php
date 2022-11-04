<?php

namespace Kubinyete\Fraugster\Model\Transaction\Sync;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;

class ApprovedUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
        ?string $acquirerReferenceId,
    ) {
        parent::__construct($id, TransactionStatus::Approved, $ts, [
            'acq_ref_id' => $acquirerReferenceId
        ]);
    }
}
