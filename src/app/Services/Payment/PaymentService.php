<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\PaymentServiceInterface;

abstract class PaymentService implements PaymentServiceInterface
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
