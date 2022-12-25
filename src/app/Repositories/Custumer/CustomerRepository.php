<?php

namespace App\Repositories\Custumer;

use App\Models\Customer;
use App\Services\Integrations\Payment\DTO\CustomerDTO;
use App\Services\Integrations\Payment\DTO\CustomerDTO as PagarmeCustomer;

interface CustomerRepository
{
    public function store(PagarmeCustomer $customer): Customer;

    public function existsByEmail(string $email): bool;

    public function updateByEmail(CustomerDTO $customer): Customer;

    public function getByEmail(string $email): Customer;

    public function getById(int $id): Customer;
}
