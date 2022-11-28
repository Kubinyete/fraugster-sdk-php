<?php

namespace Kubinyete\Fraugster\Model;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class ShoppingCart implements JsonSerializable
{
    protected array $items;

    public function __construct()
    {
        $this->items = [];
    }

    //

    protected function assertValid(): void
    {
    }

    public function addItem(ShoppingCartItem $item): void
    {
        $this->items[] = $item;
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'items' => array_map(fn (ShoppingCartItem $x) => $x->jsonSerialize(), $this->items),
        ];
    }
}
