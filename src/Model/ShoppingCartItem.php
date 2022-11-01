<?php

namespace Kubinyete\Fraugster\Model;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Decimal;

class ShoppingCartItem implements JsonSerializable
{
    public function __construct(
        protected string $id,
        protected ?string $description,
        protected int $quantity,
        protected float $amount,

        protected ?string $uniqueId = null,
        protected ?string $additionalDescription = null,
        protected ?float $discount = null,
        protected ?float $taxRate = null,

    ) {
        $this->assertValid();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(strlen($this->id), "Item id is required");
        DomainException::assert(is_null($this->description) || strlen($this->description), "Item description is required");
        DomainException::assert($this->quantity > 0, "Item quantity should be greater than zero");
        DomainException::assert($this->amount >= 0, "Item amount should be greater or equal to zero");

        DomainException::assert(is_null($this->uniqueId) || strlen($this->uniqueId), "Item unique id is required");
        DomainException::assert(is_null($this->additionalDescription) || strlen($this->additionalDescription), "Item additional description is required");
        DomainException::assert(is_null($this->discount) || $this->discount >= 0, "Item discount should be greater or equal to zero");
        DomainException::assert(is_null($this->taxRate) || $this->taxRate >= 0 && $this->taxRate <= 100.00, "Item discount should be a percentage (0-100)");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'item_id' => $this->id,
            'unique_item_id' => $this->uniqueId,
            'item_desc' => $this->description,
            'additional_description' => $this->additionalDescription,
            'item_amt' => $this->amount,
            'discount' => $this->discount,
            'tax_rate' => $this->taxRate,
            'quantity' => $this->quantity,
        ];
    }
}
