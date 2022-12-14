<?php

namespace App\Repositories\PurchaseItem;

use App\Models\Purchase;
use App\Models\PurchaseItem;

interface PurchaseItemRepository
{
    public function store(Purchase $purchase, array $item): PurchaseItem;
}
