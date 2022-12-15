<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class CreditCardNotCreatedException extends InvalidPostback
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            //TODO:: Implementar log
            trans('exceptions.payment.credit-card.not-created', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
