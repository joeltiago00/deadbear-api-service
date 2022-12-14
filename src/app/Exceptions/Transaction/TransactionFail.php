<?php

namespace App\Exceptions\Transaction;


use Illuminate\Http\Response;

class TransactionFail extends TransactionException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: Add Logging
        parent::__construct(
            trans('exceptions.transaction.fail', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
