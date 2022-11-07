<?php

namespace Kubinyete\Fraugster\Model\Transaction\Async;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;

class ApprovedManualUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
    ) {
        parent::__construct($id, TransactionStatus::ApprovedManual, $ts);
    }
}
