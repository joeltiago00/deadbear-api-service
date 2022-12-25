<?php

namespace App\Repositories\Purchase;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Transaction\Items;

interface PurchaseRepository
{
    public function store(Transaction $transaction, Customer $customer, Items $items,): Purchase;

    public function getByTransactionId(int $transactionId): Purchase;

    public function setDelivered(Purchase $purchase): void;
}
