<?php

namespace Kubinyete\Fraugster\Model\Transaction\Sync;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;

class FrgDeclinedUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
    ) {
        parent::__construct($id, TransactionStatus::FrgDeclined, $ts);
    }
}
