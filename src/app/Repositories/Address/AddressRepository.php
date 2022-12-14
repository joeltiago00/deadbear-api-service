<?php

namespace App\Repositories\Address;

use App\Core\Address\Contracts\AddressInterface;
use App\Models\Address;
use App\Models\Transaction;

interface AddressRepository
{
    public function store(Transaction $transaction, AddressInterface $address, string $type): Address;
}
