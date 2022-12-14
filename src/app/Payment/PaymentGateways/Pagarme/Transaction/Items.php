<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

class Items
{
    private array $items;

    private int $totalPrice;

    public function __construct(array ...$items)
    {
        $this->items = $items;
        $this->totalPrice = $this->setTotalPrice();
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    private function setTotalPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->items[0] as $item) {
            $totalPrice += $item['quantity'] * $item['unit_price'];
        }

        return $totalPrice;
    }

    public function getItems(): array
    {
        return $this->items[0];
    }
}
