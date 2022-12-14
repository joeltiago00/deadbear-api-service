<?php

namespace App\Payment\PaymentGateways\Pagarme;

use App\Payment\Contracts\CreditCardInterface;
use App\Payment\Contracts\PixInterface;
use App\Payment\Contracts\TransactionInterface;

class Transaction implements TransactionInterface
{

    public function creditCard(): CreditCardInterface
    {
        return new CreditCard();
    }

    public function pix(): PixInterface
    {
        return new Pix();
    }
}
