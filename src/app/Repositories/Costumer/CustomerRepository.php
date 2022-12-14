<?php

namespace App\Repositories\Costumer;

use App\Models\Client;
use App\Models\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer as PagarmeCustomer;

interface CustomerRepository
{
    public function store(Client $client, PagarmeCustomer $customer): Customer;
}
