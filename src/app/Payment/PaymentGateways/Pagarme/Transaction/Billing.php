<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

use App\Core\Address\Contracts\AddressInterface;
use JetBrains\PhpStorm\ArrayShape;

class Billing
{
    /**
     * @param string $payerName
     * @param AddressInterface $address
     */
    public function __construct(
        private readonly string           $payerName,
        private readonly AddressInterface $address,
    ) { }

    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'address' => "array"])]
    public function toArray(): array
    {
        return [
            'name' => $this->payerName,
            'address' => $this->address->toArray()
        ];
    }
}
