<?php

namespace App\Repositories\AccountStock;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;

interface AccountStockRepository
{
    public function getAccounts(int $itemId, int $quantity): Collection;

    public function setAccountDelivered(Stock $item, int $purchaseId): bool;
}
