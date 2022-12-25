<?php

namespace App\Services\Integrations\Payment\PaymentGateways\Pagarme\Contracts;

use PagarMe\Client;

interface PagarmeOperationInterface
{
    public function __construct(Client $client);
}
