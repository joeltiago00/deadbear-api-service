<?php

namespace App\Services\Payment;

use App\Exceptions\Payment\PaymentGatewayInvalidException;
use App\Services\Payment\Contracts\PaymentServiceInterface;
use App\Services\Payment\PaymentGateways\Pagarme\Pagarme;
use App\Types\PaymentGatewayTypes;

class PaymentServiceManager
{
    /**
     * @return PaymentServiceInterface
     * @throws PaymentGatewayInvalidException
     */
    public function resolve(): PaymentServiceInterface
    {
        if (config('app.payment.default_gateway') === PaymentGatewayTypes::PAGARME)
            return new Pagarme(config('app.payment.providers.pagarme.api_key'));

        throw new PaymentGatewayInvalidException();
    }
}
