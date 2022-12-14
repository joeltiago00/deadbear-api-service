<?php

namespace App\Repositories\Client;

use App\Models\Client;

interface ClientRepository
{
    public function store(string $name): Client;
}
