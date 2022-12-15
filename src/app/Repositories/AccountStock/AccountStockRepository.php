<?php

namespace App\Repositories\AccountStock;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

interface AccountStockRepository
{
    public function getAccounts(int $itemId, int $quantity): Collection;

    public function setAccountDelivered(Item $item, int $purchaseId): bool;
}
