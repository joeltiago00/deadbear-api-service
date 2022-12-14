<?php

namespace App\Exceptions\Purchase;


use Illuminate\Http\Response;

class PurchaseNotStored extends PurchaseException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: Add Logging
        parent::__construct(
            trans('exceptions.purchase.not-stored', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
