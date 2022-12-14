<?php

namespace App\Payment\Contracts;

interface TransactionInterface
{
    public function creditCard(): CreditCardInterface;

    public function pix(): PixInterface;
}
