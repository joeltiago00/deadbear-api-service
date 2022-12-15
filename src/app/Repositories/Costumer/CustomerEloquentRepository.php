<?php

namespace App\Repositories\Costumer;

use App\Exceptions\Customer\CustomerNotStored;
use App\Exceptions\Customer\CustomerNotUpdated;
use App\Models\Customer;
use App\Payment\DTO\CustomerDTO;
use App\Payment\DTO\CustomerDTO as CustomerAlias;
use App\Repositories\Repository;
use Exception;

class CustomerEloquentRepository extends Repository implements CustomerRepository
{
    public function __construct()
    {
        $this->setModel(Customer::class);
    }

    /**
     * @throws CustomerNotStored
     */
    public function store(CustomerAlias $customer): Customer
    {
        try {
            return $this->model->create([
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'document_type' => $customer->document()->getType(),
                'document_value' => $customer->document()->getValue(),
                'phone_country' => '55',//TODO:: (Joel 15/08) Handle this
                'phone_value' => $customer->getPhone()
            ]);
        } catch (Exception $exception) {
            throw new CustomerNotStored($exception);
        }
    }

    public function existsByEmail(string $email): bool
    {
        return $this->model
            ->newQuery()
            ->where('email', $email)
            ->exists();
    }

    /**
     * @throws CustomerNotUpdated
     */
    public function updateByEmail(CustomerDTO $customer): Customer
    {
        $customer = $this->model
            ->newQuery()
            ->where('email', $customer->getEmail());

        if (!$customer->update([
            'name' => $customer->getName(),
            'document_type' => $customer->document()->getType(),
            'document_value' => $customer->document()->getValue(),
            'phone_country' => '55',//TODO:: (Joel 15/08) Handle this
            'phone_value' => $customer->getPhone()
        ]))
            throw new CustomerNotUpdated();

        return $customer->firstOrFail();
    }

    public function getByEmail(string $email): Customer
    {
        return $this->model
            ->newQuery()
            ->where('email', $email)
            ->firstOrFail();
    }
}
