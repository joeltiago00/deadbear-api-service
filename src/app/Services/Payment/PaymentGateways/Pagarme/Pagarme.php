<?php

namespace App\Services\Payment\PaymentGateways\Pagarme;

use App\Services\Payment\Contracts\BoletoInterface;
use App\Services\Payment\Contracts\CreditCardInterface;
use App\Services\Payment\Contracts\PixInterface;
use App\Services\Payment\PaymentService;
use PagarMe\Client;

class Pagarme extends PaymentService
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

    public function boleto(): BoletoInterface
    {
        return new Boleto($this->client);
    }

    public function postbackIsValid(string $payload, string $signature): bool
    {
        return $this->client->postbacks()->validate($payload, $signature);
    }
}
