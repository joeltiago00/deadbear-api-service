<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class TransactionNotCreatedException extends InvalidPostback
{
    public function __construct()
    {
        parent::__construct(
            //TODO:: Implementar log
            trans('exceptions.payment.transaction-not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
