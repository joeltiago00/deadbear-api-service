<?php

namespace App\Repositories\Costumer;

use App\Exceptions\Customer\CustomerNotStored;
use App\Models\Client;
use App\Models\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer as CustomerAlias;
use App\Repositories\Repository;

class CustomerEloquentRepository extends Repository implements CustomerRepository
{
    public function __construct()
    {
        $this->setModel(Customer::class);
    }

    /**
     * @param Client $client
     * @param CustomerAlias $customer
     * @return Customer
     * @throws CustomerNotStored
     */
    public function store(Client $client, CustomerAlias $customer): Customer
    {
        try {
            return $client->customers()->create([
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'document_type' => $customer->document()->getType(),
                'document_value' => $customer->document()->getValue(),
                'phone_country' => '55',//TODO:: (Joel 09/08) Handle this
                'phone_value' => $customer->getPhone()
            ]);
        } catch (\Exception $exception) {
            throw new CustomerNotStored($exception);
        }
    }
}
