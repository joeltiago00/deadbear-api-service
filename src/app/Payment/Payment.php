<?php

namespace App\Payment;

use App\Payment\Contracts\PaymentServiceInterface;

abstract class Payment implements PaymentServiceInterface
{
    /**
     * Instance of client of payment gateway
     * @var
     */
    protected $client;

    /**
     * Api key of payment gateway to make operations.
     * @var string
     */
    protected string $apiKey;
}
