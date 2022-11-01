<?php

namespace Kubinyete\Fraugster\Model;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Type\Currency;
use Kubinyete\Fraugster\Type\IpAddress;

class Transaction implements JsonSerializable
{
    public function __construct(
        protected string $id,
        protected DateTimeInterface $ts,
        protected float $amt,
        protected Currency $currency,
        protected string $sellerId,
        protected bool $firstPurchase,
        protected IpAddress $ip,
        protected ?string $orderId,
        protected ?Account $account = null,
        protected ?Billing $billing = null,
        protected ?Card $card = null,
        protected ?Customer $customer = null,
        protected ?DeviceInfo $deviceInfo = null,
        protected ?ShoppingCart $shoppingCart = null,
    ) {
        $this->assertValidTransaction();
    }

    //

    protected function assertValidTransaction(): void
    {
        DomainException::assert(strlen($this->id), "Transaction id is required");
        DomainException::assert(strlen($this->sellerId), "Transaction seller id is required");
        DomainException::assert($this->amt >= 0, "Transaction amount should be grater or equal to zero");
        DomainException::assert(is_null($this->orderId) || strlen($this->orderId), "Transaction order id is required");
    }

    public function addItem(ShoppingCartItem $item): void
    {
        ($this->shoppingCart ?? ($this->shoppingCart = new ShoppingCart()))->addItem($item);
    }

    //

    public function jsonSerialize(): mixed
    {
        $packet = [
            'trans_id' => $this->id,
            'trans_ts' => $this->ts->format(DateTime::RFC3339),
            'trans_amt' => (string)$this->amt,
            'trans_currency' => (string)$this->currency,
            'seller_id' => $this->sellerId,
            'first_purchase' => $this->firstPurchase,
            'ip' => (string)$this->ip,
        ];

        $packet += $this->account?->jsonSerialize() ?? [];
        $packet += $this->billing?->jsonSerialize() ?? [];
        $packet += $this->card?->jsonSerialize() ?? [];
        $packet += $this->customer?->jsonSerialize() ?? [];

        if ($this->deviceInfo) {
            $packet['device_fingerprint'] = $this->deviceInfo->jsonSerialize();
        }

        return $packet;
    }
}
