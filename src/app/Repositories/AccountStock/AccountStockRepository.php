<?php

namespace App\Repositories\AccountStock;

use App\Models\AccountStock;
use Illuminate\Database\Eloquent\Collection;

interface AccountStockRepository
{
    public function getAccounts(int $itemId, int $quantity): Collection;

    public function setAccountDelivered(AccountStock $item, int $purchaseId): bool;
}
