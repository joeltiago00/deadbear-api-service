<?php

namespace App\Repositories\Purchase;

use App\Exceptions\Purchase\PurchaseNotStored;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Repositories\PurchaseItem\PurchaseItemEloquentRepository;
use App\Repositories\Repository;
use Illuminate\Support\Str;

class PurchaseEloquentRepository extends Repository implements PurchaseRepository
{
    public function __construct()
    {
        $this->setModel(Purchase::class);
    }

    /**
     * @throws PurchaseNotStored
     */
    public function store(Transaction $transaction, Customer $customer, Items $items): Purchase
    {
        try {
            $purchase = $transaction->purchase()->create([
                'total_price' => $items->getTotalPrice(),
                'customer_id' => $customer->getKey(),
                'code' => Str::random(),
                'is_delivered' => false //TODO:: REMOVER CAMPO
            ]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            throw new PurchaseNotStored($exception);
        }

        foreach ($items->getItems() as $item) {
            (new PurchaseItemEloquentRepository())->store($purchase, $item);
        }

        return $purchase;
    }

    public function getByTransactionId(int $transactionId): Purchase
    {
        return $this->model
            ->newQuery()
            ->where('transaction_id', $transactionId)
            ->firstOrFail();
    }

    public function setDelivered(Purchase $purchase): void
    {
        $purchase->update(['is_delivered' => true]);
    }
}
