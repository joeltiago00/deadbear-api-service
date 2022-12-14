<?php

namespace App\Repositories\Item;

use App\Models\Item;
use App\Repositories\Repository;

class ItemEloquentRepository extends Repository implements ItemRepository
{
    public function __construct()
    {
        $this->setModel(Item::class);
    }
}
