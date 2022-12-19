<?php

namespace App\Repositories\PurchaseItem;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Repositories\Repository;

class PurchaseItemEloquentRepository extends Repository implements PurchaseItemRepository
{
    public function __construct()
    {
        $this->setModel(PurchaseItem::class);
    }

    public function store(Purchase $purchase, array $item): PurchaseItem
    {
        return $purchase->purchaseItems()->create(array_merge($item, ['item_id' => $item['id']]));
    }
}
