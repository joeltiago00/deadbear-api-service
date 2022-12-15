<?php

namespace App\Exceptions\Customer;

use Illuminate\Http\Response;

class CustomerNotUpdated extends CustomerException
{
    public function __construct()
    {
        //TODO:: (Joel 09/08) Add Logging
        parent::__construct(
            trans('exceptions.customer.not-updated', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
