<?php

namespace App\Repositories;

use App\Exceptions\Address\AddressType\AddressTypeNotFound;
use App\Exceptions\Address\AddressType\AddressTypeNotStored;
use App\Models\AddressType;

class AddressTypeRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(AddressType::class);
    }

    /**
     * @param string $name
     * @return AddressType
     * @throws AddressTypeNotStored
     */
    public function store(string $name): AddressType
    {
        try {
            return $this->getModel()->create(['name' => $name]);
        } catch (\Exception $exception) {
            throw new AddressTypeNotStored($exception);
        }
    }

    /**
     * @param string $type
     * @return AddressType
     * @throws AddressTypeNotFound
     */
    public function getByName(string $type): AddressType
    {
        $type = $this->getModel()->where('name', $type)->first();

        if (empty($type))
            throw new AddressTypeNotFound();

        return $type;
    }
}
