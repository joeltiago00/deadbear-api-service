<?php

namespace App\Exceptions\Address;


use Illuminate\Http\Response;

class AddressNotStored extends AddressException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: Add Logging
        parent::__construct(
            trans('exceptions.address.not-stored', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
