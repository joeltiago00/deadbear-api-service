<?php

namespace App\Exceptions\Client;


use Illuminate\Http\Response;

class ClientNotStored extends ClientException
{
    public function __construct(\Throwable $throwable)
    {
        //TODO:: Add Logging
        parent::__construct(
            trans('exceptions.client.not-stored', ['error_code' => 1]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
