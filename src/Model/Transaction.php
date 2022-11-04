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
        protected PaymentMethod $paymentMethod,
        protected PaymentMethodBrand $paymentMethodBrand,
        protected ?string $status,
        protected ?string $orderId,
        protected ?Account $account = null,
        protected ?Billing $billing = null,
        protected ?Shipping $shipping = null,
        protected ?Card $card = null,
        protected ?Customer $customer = null,
        protected ?DeviceInfo $deviceInfo = null,
        protected ?ShoppingCart $shoppingCart = null,
        protected ?FixedLinePhone $phone = null,
        protected ?MobilePhone $mobilePhone = null,
        protected ?Seller $seller = null,
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
            'trans_amt' => $this->amt,
            'trans_currency' => (string)$this->currency,
            'seller_id' => $this->sellerId,
            'pmt_method' => $this->paymentMethod->value,
            'pmt_method_brand' => $this->paymentMethodBrand->value,
            'order_id' => $this->orderId,
            'device_fingerprint' => $this->deviceInfo?->jsonSerialize(),
            'first_purchase' => $this->firstPurchase,
            'ip' => (string)$this->ip,
            'phone' => $this->phone?->__toString(),
            'phone_mobile' => $this->mobilePhone?->__toString(),
        ];

        $packet += $this->account?->jsonSerialize() ?? [];
        $packet += $this->billing?->jsonSerialize() ?? [];
        $packet += $this->shipping?->jsonSerialize() ?? [];
        $packet += $this->card?->jsonSerialize() ?? [];
        $packet += $this->customer?->jsonSerialize() ?? [];
        $packet += $this->shoppingCart?->jsonSerialize() ?? [];
        $packet += $this->seller?->jsonSerialize() ?? [];

        return $packet;
    }
}
