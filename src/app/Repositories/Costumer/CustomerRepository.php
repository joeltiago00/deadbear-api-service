<?php

namespace App\Repositories\Costumer;

use App\Models\Customer;
use App\Payment\DTO\CustomerDTO as PagarmeCustomer;

interface CustomerRepository
{
    public function store(PagarmeCustomer $customer): Customer;
}
