<?php

namespace App\Repositories;

use App\Exceptions\Transaction\TransactionNotStored;
use App\Models\Customer;
use App\Models\Transaction;
use App\Payment\Contracts\TransactionResponseInterface;

class TransactionRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Transaction::class);
    }

    /**
     * @param Customer $customer
     * @param TransactionResponseInterface $response
     * @return Transaction
     * @throws TransactionNotStored
     */
    public function store(Customer $customer, TransactionResponseInterface $response): Transaction
    {
        try {
            return $customer->transactions()->create($response->toArray());
        } catch (\Exception $exception) {
            throw new TransactionNotStored($exception);
        }
    }
}
