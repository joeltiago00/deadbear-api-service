<?php

namespace App\Services\Delivery;

use App\Core\ProductSend\ItemDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Events\AutoSendBuy;
use App\Mail\PurchaseSendMail;
use App\Models\Purchase;
use App\Repositories\AccountStock\AccountStockRepository;
use App\Repositories\Purchase\PurchaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountDeliveryService
{
    public function __construct(
        private readonly AccountStockRepository $accountStockRepository,
        private readonly PurchaseRepository $purchaseRepository
    ){ }

    /**
     * @throws \Exception
     */
    public function delivery(AutoSendBuy $event): void
    {
        if ($event->status === PaymentStatusEnum::PAID->description() && !$event->purchase->is_delivered) {
            $items = $event->purchase->purchaseItems()->get();

            $accounts = $this->getAccounts($items);

            $dtos = $this->getItemsDTO($accounts);

            $this->setAccountsDelivered($event->purchase, $items, $accounts);

            try {
                Mail::to($event->customer->email)->send(new PurchaseSendMail($event->customer, $dtos));
            } catch (\Exception $exception) {
                throw new \Exception('Email not send.');
            }
        }
    }

    private function setAccountsDelivered(Purchase $purchase, Collection $items, SupportCollection $accounts): void
    {
        DB::transaction(function () use ($purchase, $items, $accounts){
             $this->purchaseRepository->setDelivered($purchase);

            $accounts->map(function ($account) use ($purchase) {
                 $this->accountStockRepository->setAccountDelivered($account, $purchase->id);
             });
        });
    }

    private function getItemsDTO(SupportCollection $accounts): array
    {
        $items = collect();

        $accounts->map(function ($accounts) use($items) {
            return $accounts->map(function ($account) use($items){
                $items->push(new ItemDTO(
                    $account->login,
                    $account->password,
                    $account->email
                ));
            })->toArray();
        })->toArray();

        return $items->toArray();
    }

    private function getAccounts(Collection $items): SupportCollection|Collection
    {
        return $items->map(function ($item) {
            return $this->accountStockRepository->getAccounts($item->item_id, $item->quantity);
        });
    }
}
