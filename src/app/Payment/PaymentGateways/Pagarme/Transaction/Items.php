<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

class Items
{
    private array $items;

    private int $totalPrice;

    public function __construct(array $items)
    {
        $this->items = $items; //TODO:: Receive array of object Item and handle with this
    }

    private function setItems(array $items): void
    {
        foreach ($items as $item) {

        }
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
