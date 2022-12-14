<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(PurchaseItem::class);
    }

    public function store(Purchase $purchase, Item $item)
    {

    }
}
