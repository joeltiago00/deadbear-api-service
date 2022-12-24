<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class CreditCardTransactionNotCreatedException extends \Exception
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            //TODO:: Implementar log
            trans('exceptions.payment.credit-card.transaction-not-created', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
