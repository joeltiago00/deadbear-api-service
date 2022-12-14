<?php

namespace App\Exceptions\Customer;

use Illuminate\Http\Response;

class CustomerNotStored extends CustomerException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: (Joel 09/08) Add Logging
        parent::__construct(
            trans('exceptions.customer.not-stored', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
