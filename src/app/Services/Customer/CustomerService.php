<?php

namespace App\Services\Customer;

use App\Core\Document\Document;
use App\Models\Customer;
use App\Payment\DTO\CustomerDTO;
use App\Repositories\Costumer\CustomerRepository;
use Illuminate\Support\Fluent;

class CustomerService
{
    public function __construct(
        private readonly CustomerRepository $customerRepository
    ){ }

    public function storeOrUpdate(Fluent $data): Customer
    {
        $document = new Document($data->document_number);

        $dto = new CustomerDTO(
            $data->first_name,
            $data->last_name,
            $data->email,
            'br',
            $document,
            $data->phone_number
        );

        if ($this->customerRepository->existsByEmail($dto->email))
            return $this->customerRepository->updateByEmail($dto);

        return $this->customerRepository->store($dto);
    }
}
