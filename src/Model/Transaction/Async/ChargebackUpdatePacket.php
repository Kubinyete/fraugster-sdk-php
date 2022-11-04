<?php

namespace Kubinyete\Fraugster\Model\Transaction\Async;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\TransactionStatus;
use Kubinyete\Fraugster\Type\Currency;

class ChargebackUpdatePacket extends UpdatePacket
{
    public function __construct(
        string $id,
        DateTimeInterface $ts,
        ?string $reasonCode,
        float $amt,
        Currency $currency,
    ) {
        parent::__construct($id, TransactionStatus::Chargeback, $ts, [
            'chbk_reason_code' => $reasonCode,
            'chbk_amt' => $amt,
            'chbk_currency' => (string)$currency,
        ]);
    }
}
