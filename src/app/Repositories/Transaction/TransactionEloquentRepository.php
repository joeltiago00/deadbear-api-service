<?php

namespace App\Repositories\Transaction;

use App\Exceptions\Transaction\TransactionNotStored;
use App\Models\Customer;
use App\Models\Transaction;
use App\Repositories\Repository;
use App\Services\Payment\Contracts\TransactionResponseInterface;

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

    public function getByTransactionProviderId(int $transactionProviderId): Transaction
    {
        return $this->model
            ->newQuery()
            ->where('transaction_provider_id', $transactionProviderId)
            ->firstOrFail();
    }

    public function updateTransactionStatus(Transaction $transaction, string $newStatus): bool
    {
        return $transaction->update(['status' => $newStatus]);
    }
}
