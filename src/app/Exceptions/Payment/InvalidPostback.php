<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class InvalidPostback extends InvalidPostback
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.payment.invalid-method'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
