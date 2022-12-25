<?php

namespace App\Services\Payment\Contracts;

interface PaymentServiceInterface
{
    public function creditCard(): CreditCardInterface;

    public function pix(): PixInterface;
}
