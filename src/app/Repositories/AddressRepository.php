<?php

namespace App\Repositories;

use App\Core\Address\Contracts\AddressInterface;
use App\Exceptions\Address\AddressNotStored;
use App\Models\Address;
use App\Models\Transaction;

class AddressRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Address::class);
    }

    /**
     * @param Transaction $transaction
     * @param AddressInterface $address
     * @param string $type
     * @return Address
     * @throws AddressNotStored
     */
    public function store(Transaction $transaction, AddressInterface $address, string $type): Address
    {
        try {
            $type = (new AddressTypeRepository())->getByName($type);

            $data = array_merge($address->toArray(), ['address_type_id' => $type->id]);

            return $transaction->addresses()->create($data);
        } catch (\Exception $exception) {
            throw new AddressNotStored($exception);
        }
    }
}
