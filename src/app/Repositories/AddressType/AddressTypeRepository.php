<?php

namespace App\Repositories\AddressType;

use App\Models\AddressType;

interface AddressTypeRepository
{
    public function store(string $name): AddressType;

    public function getByName(string $type): AddressType;
}
