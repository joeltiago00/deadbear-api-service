<?php

namespace App\Payment\Contracts;

interface PaymentServiceInterface
{
    public function creditCard(): CreditCardInterface;

    public function pix(): PixInterface;
}
