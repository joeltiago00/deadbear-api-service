<?php

namespace App\Repositories;

use App\Exceptions\Purchase\PurchaseNotStored;
use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;

class PurchaseRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Purchase::class);
    }

    public function store(
        Transaction $transaction,
        Items $items,
        bool $is_delivery = false,
        ?Address $billing = null,
        ?Address $shipping = null,
    )
    {
        try {
            $purchase = $transaction->purchase()->create([
                'is_delivery' => $is_delivery,
                'billing_id' => is_null($billing) ? null : $billing->id,
                'shipping_id' => is_null($shipping) ? null : $shipping->id,
                'total_price' => $items->getTotalPrice()
            ]);
        } catch (\Exception $exception) {
            throw new PurchaseNotStored($exception);
        }

        $items = $items->toArray();

        foreach ($items as $item) {
            $purchase_items[] = (new PurchaseItemRepository())->store();
        }
    }
}
