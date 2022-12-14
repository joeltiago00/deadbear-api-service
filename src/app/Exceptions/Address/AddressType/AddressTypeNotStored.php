<?php

namespace App\Exceptions\Address\AddressType;

use App\Exceptions\Address\AddressException;
use Illuminate\Http\Response;

class AddressTypeNotStored extends AddressException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: Add Logging
        parent::__construct(
            trans('exceptions.address.type.not-stored', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
