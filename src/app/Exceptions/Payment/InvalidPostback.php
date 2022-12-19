<?php

namespace App\Exceptions\Payment;


use Illuminate\Http\Response;

class InvalidPostback extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.payment.invalid-postback'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
