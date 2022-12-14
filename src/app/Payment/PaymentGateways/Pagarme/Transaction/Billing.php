<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

use App\Core\Address\Address;

class Billing
{
    /**
     * @param string $payerName
     * @param Address $address
     */
    public function __construct(
        private readonly string           $payerName,
        private readonly Address $address,
    ) { }

    public function toArray(): array
    {
        return [
            'name' => $this->payerName,
            'address' => $this->address->toArray()
        ];
    }
}
