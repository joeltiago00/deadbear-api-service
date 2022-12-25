<?php

namespace App\Services\Integrations\Payment\Contracts;

interface PaymentServiceInterface
{
    public function creditCard(): CreditCardInterface;

    public function pix(): PixInterface;
}
