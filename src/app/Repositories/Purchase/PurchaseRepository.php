<?php

namespace App\Repositories\Purchase;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;

interface PurchaseRepository
{
    public function store(Transaction $transaction, Customer $customer, Items $items,): Purchase;
}
