<?php

namespace App\Services\Payment\PaymentGateways\Pagarme\Transaction;

use App\Core\Address\Address;

class Shipping
{
    /**
     * @param string $receiverName
     * @param int $fee
     * @param string $deliveryDate
     * @param Address $address
     * @param bool $expedited
     */
    public function __construct(
        private readonly string $receiverName,
        private readonly int $fee, //price of delivery
        private readonly string $deliveryDate,
        private readonly Address $address,
        private readonly bool $expedited = false,
    ) { }

    /**
     * @return string
     */
    public function getReceiverName(): string
    {
        return $this->receiverName;
    }

    /**
     * @return int
     */
    public function getFee(): int
    {
        return $this->fee;
    }

    /**
     * @return string
     */
    public function getDeliveryDate(): string
    {
        return $this->deliveryDate;
    }

    /**
     * @return bool
     */
    public function isExpedited(): bool
    {
        return $this->expedited;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->receiverName,
            'fee' => $this->fee,
            'delivery_date' => $this->deliveryDate,
            'expedited' => $this->expedited,
            'address' => $this->address->toArray()
        ];
    }
}

