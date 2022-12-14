<?php

namespace App\Payment\PaymentGateways\Pagarme\Responses;

use App\Payment\Contracts\CreditCardResponseInterface;
use Illuminate\Support\Fluent;

class CreditCardResponse implements CreditCardResponseInterface
{
    /**
     * @param Fluent $response
     */
    public function __construct(
        private readonly Fluent $response,
    ) { }

    /**
     * @return string
     */
    public function getCardId(): string
    {
       return $this->response->id;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->response->brand;
    }

    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->response->holder_name;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->response->expiration_date;
    }

    /**
     * @return string
     */
    public function getFirstDigits(): string
    {
        return $this->response->first_digits;
    }

    /**
     * @return string
     */
    public function getLastDigits(): string
    {
        return $this->response->last_digits;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->response->country;
    }
}
