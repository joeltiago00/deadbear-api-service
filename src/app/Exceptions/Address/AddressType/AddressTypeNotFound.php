<?php

namespace App\Exceptions\Address\AddressType;

use App\Exceptions\Address\AddressException;
use Illuminate\Http\Response;

class AddressTypeNotFound extends AddressException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.address.type.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
