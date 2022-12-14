<?php

namespace App\Repositories\Client;

use App\Exceptions\Client\ClientNotStored;
use App\Models\Client;
use App\Repositories\Repository;

class ClientEloquentRepository extends Repository implements ClientRepository
{
    public function __construct()
    {
        $this->setModel(Client::class);
    }

    /**
     * @param string $name
     * @return Client
     * @throws ClientNotStored
     */
    public function store(string $name): Client
    {
        try {
            return $this->getModel()->create(['name' => $name]);
        } catch (\Exception $exception) {
            throw new ClientNotStored($exception);
        }
    }
}
