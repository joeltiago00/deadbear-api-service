<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class PaymentGatewayInvalidException extends PaymentException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.payment.invalid-gateway'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
