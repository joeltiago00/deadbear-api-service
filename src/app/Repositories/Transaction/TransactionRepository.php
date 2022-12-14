<?php

namespace App\Repositories\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use App\Payment\Contracts\TransactionResponseInterface;

interface TransactionRepository
{
    public function store(Customer $customer, TransactionResponseInterface $response): Transaction;
}
