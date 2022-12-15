<?php

namespace App\Repositories\AccountStock;

use App\Models\Item;
use App\Models\Stock;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AccountStockEloquentRepository extends Repository implements AccountStockRepository
{
    public function __construct()
    {
        $this->setModel(Stock::class);
    }

    public function getAccounts(int $itemId, int $quantity): Collection
    {
        return $this->model
            ->newQuery()
            ->where('item_id', $itemId)
            ->where('is_delivered', false)
            ->take($quantity)
            ->get();
    }

    public function setAccountDelivered(Item $item, int $purchaseId): bool
    {
        return $item->update([
            'is_delivered' => true,
            'delivered_at' => Carbon::now(),
            'purchase_id' => $purchaseId,
        ]);
    }
}
