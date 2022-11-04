<?php

namespace Kubinyete\Fraugster\Model\Transaction;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\TransactionStatus;

class UpdatePacket implements JsonSerializable
{
    public function __construct(
        protected string $id,
        protected TransactionStatus $status,
        protected DateTimeInterface $ts,
        protected array $fields = [],
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            "$this->id" => [
                'status' => $this->status->value,
                'ts' => $this->ts->format(DATE_RFC3339),
                ...$this->fields,
            ]
        ];
    }
}
