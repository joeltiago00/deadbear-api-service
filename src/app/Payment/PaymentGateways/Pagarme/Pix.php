<?php

namespace App\Payment\PaymentGateways\Pagarme;

use App\Payment\Contracts\PixInterface;
use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use PagarMe\Client;

class Pix implements PixInterface, PagarmeOperationInterface
{
    public function __construct(
        private readonly Client $client
    ){ }
}
