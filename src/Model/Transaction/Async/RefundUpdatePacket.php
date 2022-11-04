<?php

namespace Kubinyete\Fraugster\Model\Transaction\Async;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;
use Kubinyete\Fraugster\Type\Currency;

class RefundUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
        float $amt,
        Currency $currency,
    ) {
        parent::__construct($id, TransactionStatus::Refund, $ts, [
            'status_update_amt' => $amt,
            'status_update_currency' => (string)$currency,
        ]);
    }
}
