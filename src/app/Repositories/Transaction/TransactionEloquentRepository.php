<?php

namespace App\Repositories\Transaction;

use App\Exceptions\Transaction\TransactionNotStored;
use App\Models\Customer;
use App\Models\Transaction;
use App\Payment\Contracts\TransactionResponseInterface;
use App\Repositories\Repository;

class TransactionEloquentRepository extends Repository implements TransactionRepository
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
