<?php

namespace App\Payment;

use App\Exceptions\Payment\PaymentGatewayInvalidException;
use App\Payment\Contracts\PaymentServiceInterface;
use App\Payment\PaymentGateways\Pagarme\Pagarme;
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
