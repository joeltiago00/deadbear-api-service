<?php

namespace App\Core\Payment\Pix;

use App\Core\Payment\Contracts\CustomerInterface;
use App\Core\Payment\Contracts\PixTransactionInterface;
use Carbon\Carbon;

class PixTransaction implements PixTransactionInterface
{

    public function __construct(
        private readonly int $amount,
        private readonly CustomerInterface $customer
    ) { }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getExpirationDate(): string
    {
        return Carbon::now()->addMinutes(config('app.ttl_qr_code_pix'))->format('Y-m-d\TH:i:s');
    }

    public function customer(): CustomerInterface
    {
        return $this->customer;
    }
}
