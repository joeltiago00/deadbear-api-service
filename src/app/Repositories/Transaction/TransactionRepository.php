<?php

namespace App\Repositories\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use App\Services\Integrations\Payment\Contracts\TransactionResponseInterface;

interface TransactionRepository
{
    public function store(Customer $customer, TransactionResponseInterface $response): Transaction;

    public function getByTransactionProviderId(int $transactionProviderId): Transaction;

    public function updateTransactionStatus(Transaction $transaction, string $newStatus): bool;
}
