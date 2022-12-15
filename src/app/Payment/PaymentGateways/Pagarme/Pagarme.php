<?php

namespace App\Payment\PaymentGateways\Pagarme;

use App\Payment\Contracts\CreditCardInterface;
use App\Payment\Contracts\PixInterface;
use App\Payment\Payment;
use PagarMe\Client;

class Pagarme extends Payment
{
    /**
     * @param string $apiKey
     */
    public function __construct(
        protected string $apiKey
    )
    {
        $this->client = new Client($this->apiKey);
    }

    public function creditCard(): CreditCardInterface
    {
        return new CreditCard($this->client);
    }

    public function pix(): PixInterface
    {
        return new Pix($this->client);
    }

    public function boleto()
    {
        return new Boleto($this->client);
    }

    public function postbackIsValid(string $payload, string $signature): bool
    {
        return $this->client->postbacks()->validate($payload, $signature);
    }
}
