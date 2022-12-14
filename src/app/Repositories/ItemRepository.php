<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Item::class);
    }
}
